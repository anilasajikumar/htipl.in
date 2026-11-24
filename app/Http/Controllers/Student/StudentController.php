<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Certificates;
use App\Models\CourseMedia;
use App\Models\CourseModule;
use App\Models\ExamMarks;
use App\Models\Files;
use App\Models\StudentCourse;
use App\Models\StudentRegisterNumber;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use PDF;
use Toastr;
use Yajra\Datatables\Datatables;
use DB;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam_attented = ExamMarks::select('exam_marks.id')
        ->where('exam_marks.register_number','=',Auth::guard('student')->user()->register_number)
        ->first(); 
        
      $student = Auth::guard('student')->user();

    if (!$student) {
        return redirect()->route('student.login');
    }

       $my_courses = \DB::table('course_modules')
        ->whereNull('course_modules.deleted_at')
        ->where('course_modules.status', 1)
        ->select(
            'course_modules.id',
            'course_modules.course_module_name',
            'course_modules.course_module_description'
        )
        ->orderBy('course_modules.id', 'DESC')
        ->get();

        $find_reg_number = StudentRegisterNumber::where('student_courses_id','=',Auth::guard('student')->user()->id)->first();

        // All enrollments for this student (same email)
        $all_enrollments = StudentCourse::select(
                'student_courses.register_number',
                'student_courses.id',
                'online_courses.course_name'
            )
            ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where('student_courses.email', Auth::guard('student')->user()->email)
            ->whereNull('student_courses.deleted_at')
            ->get();

        return view('student.home', compact('exam_attented','find_reg_number','my_courses','all_enrollments'));
    }

    public function myCourseModuleData()
    {
          $my_courses = StudentCourse::select('course_modules.*')
        ->join('center_online_courses', 'student_courses.center_online_courses_id', '=', 'center_online_courses.id')
        ->join('online_courses', 'center_online_courses.course_id', '=', 'online_courses.id')
        ->join('course_modules', 'online_courses.id', '=', 'course_modules.course_id')
        ->where('student_courses.register_number', Auth::guard('student')->user()->register_number)
        ->whereNull('course_modules.deleted_at')
        ->get();

    return view('student.my-course-modules', compact('my_courses'));
    }

    public function getAllVideoMedias($course_module_name)
    {
        $course_module = CourseModule::select('id')->where('course_module_name','=',$course_module_name)->first();
        if($course_module == null){
            return abort(404);
        }
        $id = $course_module->id;
       $course_media = CourseMedia::join('media', 'course_media.id', '=', 'media.course_media_id')
    ->where('course_media.course_module_id', $id)
    ->whereNotNull('media.link')        // video link only
    ->where('media.status', 1)
    ->orderBy('media.id', 'asc')
    ->select(
        'media.title',
        'media.link',
        'course_media.course_media_description'
    )
    ->get(); 


        if($course_media == null){
            return abort(404);
        }

        return view('student.media-list',compact('course_media'));
    }


    public function getAllPdfMedias($course_module_name)
    {
        $course_module = CourseModule::select('id')->where('course_module_name','=',$course_module_name)->first();
        if($course_module == null){
            return abort(404);
        }
        $id = $course_module->id;
        // $course_media = CourseMedia::select('course_media.course_module_id','media.*','course_media.course_media_description')
        // ->join('media','course_media.id','media.course_media_id')
        // ->join('course_modules','course_media.course_module_id','course_modules.id')
        // ->join('online_courses','course_modules.course_id','online_courses.id')
        // ->join('center_online_courses','online_courses.id','center_online_courses.course_id')
        // ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        // ->where([['course_media.course_module_id','=',$id],['student_courses.register_number','=',Auth::guard('student')->user()->register_number],['media.extension','=','pdf']])
        // ->orderBy('media.id','asc')
        // ->get();
        
        $course_media = CourseMedia::join('media', 'course_media.id', '=', 'media.course_media_id')
    ->where('course_media.course_module_id', $id)
    ->whereNotNull('media.pdf_link')     // PDF link only
    ->where('media.status', 1)
    ->orderBy('media.id', 'asc')
    ->select(
        'media.title',
        'media.pdf_link',
        'course_media.course_media_description'
    )
    ->get(); 

        if($course_media == null){
            return abort(404);
        }

        return view('student.media-list',compact('course_media'));
    }

    public function getAllMediaLinks($course_module_name)
    {
        $course_module = CourseModule::select('id')->where('course_module_name','=',$course_module_name)->first();
        if($course_module == null){
            return abort(404);
        }
        $id = $course_module->id;
        $course_media = CourseMedia::select('course_media.course_module_id','media_links.*','course_media.course_media_description')
        ->join('media_links','course_media.id','media_links.course_media_id')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('online_courses','course_modules.course_id','online_courses.id')
        ->join('center_online_courses','online_courses.id','center_online_courses.course_id')
        ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        ->where([['course_media.course_module_id','=',$id],['student_courses.register_number','=',Auth::guard('student')->user()->register_number]])
        ->orderBy('media_links.order','asc')
        ->get();

        if($course_media == null){
            return abort(404);
        }

        return view('student.media-link-list',compact('course_media'));
    }

    public function startExam()
    {
        $data = StudentCourse::select('questions.id','questions.question','questions.option_a','questions.option_b','questions.option_c','questions.option_d','questions.image')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('course_exams','center_online_courses.course_id','course_exams.course_id')
        ->join('questions','course_exams.id','questions.course_exam_id')
        ->where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)
        ->get();

        $total_questions = StudentCourse::select('course_exams.total_questions')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('course_exams','center_online_courses.course_id','course_exams.course_id')
        ->where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)
        ->first();


        if($total_questions->total_questions != $data->count() || $data->count() == null){
            Toastr::error('No Active Exam', 'Not Found');
            return Redirect(route('student-home'));
        }


        $exam_details = StudentCourse::select('course_exams.exam_name','course_exams.total_questions','course_exams.total_marks','course_exams.total_time')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('course_exams','center_online_courses.course_id','course_exams.course_id')
        ->where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)
        ->first();

        return view('student.exam.index',compact('data','exam_details'));
    }



    public function submitResult(Request $request)
    {
        // check already appeared
        $appeared = ExamMarks::where('register_number','=',Auth::guard('student')->user()->register_number)
        ->first();

        if($appeared != null){
        Toastr::error('Result Already Published', 'error');
        return Redirect(route('student-home'));
        }

        $student_answer = $request->get('data');
        $time = $request->get('time');
        // $time = Carbon::parse($request->get('time'))->format('His');
        // return $time;



        // check Correct Answers
        $Correctanswer = 0;
        $Wronganswer = 0;
        if($student_answer != null){
        foreach ($student_answer as $key => $value) {

        $questions = StudentCourse::select('questions.id','questions.answer')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('course_exams','center_online_courses.course_id','course_exams.course_id')
        ->join('questions','course_exams.id','questions.course_exam_id')
        ->where([['questions.id','=',$key],['questions.answer','=',$value],['student_courses.register_number','=',Auth::guard('student')->user()->register_number]])
        ->first();
        if($questions != null){
            $Correctanswer++;
        }
        else
        {
            $Wronganswer++;
        }
    }
}

    // calculate mark
    $exam_details = StudentCourse::select('course_exams.id','course_exams.exam_name','course_exams.total_questions','course_exams.total_marks','course_exams.total_time','course_exams.mark_per_question','course_exams.minus_mark_per_question','course_exams.pass_mark','centers.study_center_name','online_courses.course_name')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('course_exams','center_online_courses.course_id','course_exams.course_id')
        ->join('centers','center_online_courses.center_id','centers.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)
        ->first();
    $mark_scored = $Correctanswer*$exam_details->mark_per_question;
    $minus_mark = $Wronganswer*$exam_details->minus_mark_per_question;
    $total_mark =  $mark_scored-$minus_mark;

    
    $publish_result = StudentCourse::where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)->first();
    if($total_mark >= $exam_details->pass_mark){
    $publish_result->result = 'pass';
    }else{
      $publish_result->result = 'fail';  
    }
    $publish_result->save();

    $exam_marks = new ExamMarks;
    $exam_marks->exam_id = $exam_details->id;
    $exam_marks->register_number = Auth::guard('student')->user()->register_number;
    $exam_marks->correct_answers = $Correctanswer;
    $exam_marks->incorrect_answers = $Wronganswer;
    $exam_marks->unanswered = ($exam_details->total_questions-($Correctanswer+$Wronganswer));
    $exam_marks->mark_scored = $total_mark; 
    $exam_marks->total_mark = $exam_details->total_marks;
    $exam_marks->time_took = '0';
    $exam_marks->total_time = $exam_details->total_time;
    $exam_marks->exam_date = Carbon::now();
    $exam_marks->save();

    $check_cert = Certificates::all();
      if($check_cert->isEmpty()){
        $certificate_id = "HTI0001";
      }
      else
      {
        $latest = Certificates::latest()->first();
        $certificate_id = ++$latest->certificate_id;
      }

    $certificate = new Certificates;
    $certificate->certificate_id = $certificate_id;
    $certificate->exam_marks_id = $exam_marks->id;
    $certificate->student_id = Auth::guard('student')->user()->id;
    $certificate->student_name = Auth::guard('student')->user()->name;
    $certificate->center_name = $exam_details->study_center_name;
    $certificate->course_name = $exam_details->course_name;
    $certificate->date_of_awarded = Carbon::now();
    $certificate->total_mark_scored = $exam_marks->mark_scored;
    $certificate->total_mark = $exam_marks->total_mark;
    $certificate->save();

    // Toastr::success('Exam SuccessFully Completed', 'success');
    // return view('student.exam.success',compact('exam_marks'));

    return response()->json([
            'success' => true,
            'message' => 'Exam SuccessFully Completed',
        ]);

    }

    public function getCertificate()
    {
       $certificate = Certificates::where([['student_id','=',Auth::guard('student')->user()->id],['student_name','=',Auth::guard('student')->user()->name]])->first();

       if($certificate == null){
        Toastr::error('No Certificate Found', 'Not Found');
        return redirect()->back();
       }

        $publish_result = StudentCourse::where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)->first();

        if($publish_result->result == 'fail'){
            Toastr::error('Failed In Exam  !!Better Luck Next Time!!', 'Error');
            return redirect()->back();
        }

       $customPaper = array(0,0,720,900);
       $pdf = PDF::loadView('student.certificate',compact('certificate'))->setPaper($customPaper,'portrait');
        return $pdf->download('certificate.pdf');
    }

    public function changePasswordForm()
    {
        return view('student.settings.change_password');
    }


    public function changePassword(Request $request)
    {
        $this->validate($request, [
        'password' => 'required |confirmed| min:6 | max:12',
     ]);
    
        $student = StudentCourse::find(Auth::guard('student')->user()->id);
        $student->password = Hash::make($request['password']);
        $student->save();

        Toastr::success('Password Successfully Changed', 'Success');
        return Redirect(route('student-home'));
    }

    public function getResult()
    {
        $exam_marks = ExamMarks::where('register_number','=',Auth::guard('student')->user()->register_number)
        ->first();

        $published_result = StudentCourse::where('student_courses.register_number','=',Auth::guard('student')->user()->register_number)->first();

        if($exam_marks == null){
        Toastr::error('No Result Found', 'Not Found');
        return redirect()->back();
       }

        return view('student.exam.success',compact('exam_marks','published_result'));
    }

    public function getFiles()
    {
        $files = Files::where('student_courses_id','=',Auth::guard('student')->user()->id)->get();
        return view('student.file-list',compact('files'));
    }

    public function getAlerts()
    {
         $alerts = Alert::select('alerts.*')->get();
        return view('student.alerts',compact('alerts'));
    }
     public function examsattend()
    { 
        $studentId = Auth::guard('student')->id();

        $exams = DB::table('examupload')
            ->orderBy('id', 'desc')
            ->get();

        // already submitted exams
        $submitted = DB::table('exam_submissions')
            ->where('student_id', $studentId)
            ->pluck('exam_id')
            ->toArray();

        return view('student.examsattendsubmit', compact('exams', 'submitted'));
    }

    /**
     * Submit exam answer
     */
   public function examsattendsubmit(Request $request, $id)
    {
        $request->validate([
            'answer_file' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);
    
        // upload file
        $file = $request->file('answer_file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('exam_answers'), $fileName);
    
        // save directly to table
        DB::table('exam_submissions')->insert([
            'exam_id'      => $id,
            'student_id'   => Auth::guard('student')->id(),
            'file_path'    => 'exam_answers/'.$fileName,
            'submitted_at' => now(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    
        return redirect()->back()->with('success', 'Exam submitted successfully');
    }
}

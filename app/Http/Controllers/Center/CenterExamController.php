<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Mail\CreateExamNotificationMail;
use App\Mail\StudentPasswordSendMail;
use App\Models\AnswerFile;
use App\Models\CenterExams;
use App\Models\ExamCenters;
use App\Models\ExamCertificates;
use App\Models\ExamUnits;
use App\Models\Exams;
use App\Models\StudentExams;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;
use PDF;
use Toastr;
use Yajra\Datatables\Datatables;

class CenterExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('center.exam.pending_exams');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exams = CenterExams::join('exams','center_exams.exam_id','exams.id')
        ->where('center_exams.center_id','=',Auth::guard('center')->user()->id)
        ->pluck('exams.id','exam_name');

        return view('center.exam.create',compact('exams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'exam' => 'required',
            'center' => 'required',
            'address' => 'required',
            'date' => 'required',
        ]);

        $center_exam = new ExamCenters;
        $center_exam->exam_id = $request->exam;
        $center_exam->center_id = Auth::guard('center')->user()->id;
        $center_exam->center= $request->center;
        $center_exam->center_address = $request->address;
        $center_exam->date = date("Y-m-d", strtotime($request->date));
        $center_exam->payment_due_date = Carbon::parse($center_exam->date)->subDay(5);
        $center_exam->closing_date = Carbon::parse($center_exam->date)->subDay(10);
        $center_exam->save();

        $exam = ExamCenters::select('exams.exam_name','exam_centers.*')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('exam_centers.id','=',$center_exam->id)
        ->first(); 

        $mail = env('TO_MAIL');
        try{
        Mail::to($mail)->send(new CreateExamNotificationMail($exam));
        }
        catch(Exception $e){
            Toastr::success('Successfully Created', 'Success');
            return redirect(route('study-center-exam.index'));
        }

        Toastr::success('Successfully Created', 'Success');
        return redirect(route('study-center-exam.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam_center_id = $id;
        return view('center.exam.students',compact('exam_center_id'));
    }


    public function completedExamStudents($id)
    {
        $exam_center_id = $id;
        return view('center.exam.completed_exam_student',compact('exam_center_id'));
    }


    public function dateData($exam)
    {
        $exams = Exams::findOrFail($exam);

        if($exams == null){
            return abort(404);
        };

        $about_date = $exams->register_before_days;
        
        return $about_date;
    }

    public function pendingExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email as email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.status','=','0']])
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('study-center-exam.show',$exams->id).'">View</a>';
           })->addColumn('register', function ($exams) {
               return '<a href="'.route('study-center-exam.register-form',$exams->id).'" class="btn btn-info btn-fw">Register</a>';
           })
        ->rawColumns(['register','view'])
        ->addIndexColumn()
        ->make(true);
    }


    public function activeExam()
    {
        return view('center.exam.active_exams');
    }


    public function activeExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email as email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->whereDate('exam_centers.closing_date','>=',Carbon::now())
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.status','=','1']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('study-center-exam.show',$exams->id).'">View</a>';
           })->addColumn('register', function ($exams) {
               return '<a href="'.route('study-center-exam.register-form',$exams->id).'" class="btn btn-info btn-fw">Register</a>';
           })
        ->rawColumns(['register','view'])
        ->addIndexColumn()
        ->make(true);
    }


    public function completedExam()
    {
        return view('center.exam.completed_exams');
    }


    public function completedExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email as email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.date','<',Carbon::now()],['exam_centers.result_published','=','No']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('completed_exam_student',$exams->id).'">View</a>';
           })
        ->rawColumns(['view'])
        ->addIndexColumn()
        ->make(true);
    }


    public function closedExam()
    {
        return view('center.exam.closed_exams');
    }


    public function closedExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email as email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->whereDate('exam_centers.closing_date','<',Carbon::now())
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.payment_status','=','0']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('study-center-exam.show',$exams->id).'">View</a>';
           })->addColumn('invoice', function ($exams) {
               return '<a href="'.route('study-center-exam.invoice',$exams->id).'" class="btn btn-info btn-fw">invoice</a>';
           })
        ->rawColumns(['invoice','view'])
        ->addIndexColumn()
        ->make(true);
    }


    public function liveExam()
    {
        return view('center.exam.live_exams');
    }


    public function liveExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email as email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.closing_date','<',Carbon::now()],['exam_centers.payment_status','=','1'],['exam_centers.status','=','3']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('hall_ticket.students',$exams->id).'">View</a>';
           })->addColumn('register', function ($exams) {
               return '<a href="'.route('study-center-exam.register-form',$exams->id).'" class="btn btn-info btn-fw">Register</a>';
           })
        ->rawColumns(['register','view'])
        ->addIndexColumn()
        ->make(true);
    }


    public function hallticketList($id)
    {
        $exam_center_id = $id;
        return view('center.exam.hallticket_students',compact('exam_center_id'));
    }


    public function hallticketListData($id)
    {
        $students = StudentExams::select('student_exams.*')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['student_exams.exam_center_id','=',$id]])
        ->get();

        return Datatables::of($students)->addColumn('hall_ticket', function ($students) {
               return '<a href="'.route('hall_tickets.download',$students->id).'" class="btn btn-info btn-fw">Download</a>';
           })
        ->rawColumns(['hall_ticket'])
        ->addIndexColumn()
        ->make(true);
    }


    public function downloadHallTickets($id)
    {
      $data = StudentExams::select('student_exams.register_number','student_exams.name','student_exams.email','student_exams.mobile','student_exams.address','exams.exam_name','exam_centers.center_address','centers.study_center_name','centers.study_center_address','exam_centers.date','exams.id as examination_id','centers.study_center_mobile','centers.study_center_email')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where([['student_exams.id','=',$id],['exam_centers.center_id','=',Auth::guard('center')->user()->id]])
        ->first();

        $exam_units = ExamUnits::select('exam_units.*')
      ->where('exam_units.exam_id','=',$data->examination_id)
      ->get();

        if($data == null){
            return abort(404);
        }
      $pdf = PDF::loadView('center.exam.hall_ticket',compact('data','exam_units'));
        return $pdf->download('hall_ticket.pdf');
    }



    public function ExamEnrollStudentForm($slug)
    {
        $exams = ExamCenters::select('exams.exam_name','exam_centers.*')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.id','=',$slug]])
        ->first();

        return view('center.exam.enroll_students',compact('exams'));
    }


    public function ExamEnrollStudent(Request $request)
    {
        $this->validate($request,[
            'exam_name'=>'required',
            'name'=>'required',
            'email'=>'required|email',
            'mobile'=>'required|min:6|max:16',
            'dob'=>'required',
            'gender'=>'required',
            'address'=>'required|max:255',
        ]);

        $exam_center_id = ExamCenters::select('exam_centers.*')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where([['exams.exam_name','=',$request->exam_name],['exam_centers.center_id','=',Auth::guard('center')->user()->id]])
        ->first();
        
        if($exam_center_id == null){

            return abort(404);
        }

        $exam_name = preg_replace('/\s*/', '', $request->exam_name);
        // convert the string to all lowercase
        $exam_name = strtoupper($exam_name);

        $check_null = StudentExams::withTrashed()->get();
      if($check_null->isEmpty()){
        $register_number = "HTI1098";
      }
      else
      {
        $latest = StudentExams::withTrashed()->latest()->first();
        $register_number = ++$latest->register_number;
      }

        $course_students = new StudentExams;
        $course_students->exam_center_id = $exam_center_id->id;
        $course_students->register_number = $register_number;
        $course_students->name = $request->name;
        $course_students->email = $request->email;
        $course_students->mobile = $request->mobile;
        $course_students->dob = $request->dob;
        $course_students->gender = $request->gender;
        $course_students->address = $request->address;
        // $password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);
        // $course_students->password = Hash::make($password);
        $course_students->save();

        $mail = $request->email;
        // Mail::to($mail)->send(new StudentPasswordSendMail($course_students, $password));

        Toastr::success('Successfully Added', 'Success');

     return redirect(route('active_exam'));
    }

    public function studentListData($id)
    {
        $students = StudentExams::select('student_exams.*')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['student_exams.exam_center_id','=',$id]])
        ->get();

        return Datatables::of($students)->make(true);
    }

    public function completedExamStudentsData($id)
    {
        $students = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['student_exams.exam_center_id','=',$id]])
        ->get();

        return Datatables::of($students)->addColumn('upload', function ($students) {
            if($students->type != 'ICRQ'){
               return '<a href="'.route('answer_papers.upload',$students->id).'" class="btn btn-info btn-fw">Upload File</a>';
            }
            return '';
           })
        ->rawColumns(['upload'])
        ->make(true);
    }

    public function Invoice($id)
    {
         $data = ExamCenters::select('exams.exam_name','exams.exam_fee','exam_centers.*','centers.study_center_email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.id','=',$id],['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.closing_date','<=',Carbon::now()],['exam_centers.status','=','1']])
        ->withCount('studentExams')
        ->first();

        if($data == null){
            return abort(404);
        }

        $pdf = PDF::loadView('center.invoice',compact('data'));
        return $pdf->download('invoice.pdf');
    }

    public function uploadAnswerFile($id)
    {
        $student_id = $id;
        $files = AnswerFile::where('student_id','=',$student_id)->get();
        return view('center.exam.upload_answers',compact('student_id','files'));
    }

    public function SaveAnswerFile(Request $request, $id)
    {
         $this->validate($request, [
                'file' => 'required',
                'file.*' => 'mimes:pdf'
        ],['file.*' => 'The file must be a file of type: pdf.']);
        
        
        if($request->hasfile('file'))
        {

            foreach($request->file('file') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->move(storage_path().'/app/public/answer_files/', $name);  
  
                $answer_file = new AnswerFile();
                $answer_file->student_id = $id;
                $answer_file->file = 'answer_files/'.$name;
                $answer_file->save();
            }

            Toastr::success('Successfully Added', 'Success');
            return redirect()->back();
        }
    }

    public function DeleteAnswerFile($id)
    {
        $file = AnswerFile::findOrFail($id);
        if($file == null){
            abort(404);
        }
        $file->delete();
        return redirect()->back();

    }

     public function ResultPublishedExam()
    {
        return view('center.exam.result_published_exams');
    }


    public function ResultPublishedExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.center_id','=',Auth::guard('center')->user()->id],['exam_centers.date','<',Carbon::now()],['exam_centers.result_published','=','Yes']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('students_result',$exams->id).'">View More</a>';
           })
        ->rawColumns(['view'])
        ->addIndexColumn()
        ->make(true);
    }

     public function ResultPublishedStudents($id)
    {
        $exam_center_id = $id;
        return view('center.exam.result_published_students',compact('exam_center_id'));
    }


    public function ResultPublishedStudentsData($id)
    {
       $students = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where([['student_exams.exam_center_id','=',$id],['centers.id','=',Auth::guard('center')->user()->id]])
        ->get();

         return Datatables::of($students)->addColumn('download_results', function ($students) {
               return '<a href="'.route('download.students_result',$students->id).'" class="btn btn-info btn-fw">Download Result</a>';
           })->addColumn('download_certificate', function ($students) {
               return '<a href="'.route('download.students_certificate',$students->id).'" class="btn btn-primary btn-fw">Download Certificate</a>';
           })
        ->rawColumns(['download_results','download_certificate'])
        ->make(true);
    }

    public function downloadResultFile($id)
    {
        $files = StudentExams::findOrFail($id);

        if($files == null){
        abort(404);
        }

        return Storage::disk('public')->download($files->file,'result.pdf');
    }

    public function downloadCertificate($id)
    {
      $certificate = ExamCertificates::where('student_exam_id','=',$id)->first();

      if($certificate == null){
        abort(404);
      }

      if($certificate->result == 'fail'){
            Toastr::error('Failed In Exam', 'Error');
            return redirect()->back();
        }

       $customPaper = array(0,0,720,900);
       $pdf = PDF::loadView('center.exam.certificate',compact('certificate'))->setPaper($customPaper,'portrait');
       
        return $pdf->download('certificate.pdf');
    }
}

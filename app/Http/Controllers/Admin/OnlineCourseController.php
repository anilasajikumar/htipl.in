<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CenterOnlineCourse;
use App\Models\Centers;
use App\Models\Certificates;
use App\Models\OnlineCourse;
use App\Models\StudentCourse;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Toastr;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use PDF;


class OnlineCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.online_course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $category = Categories::where('type','!=','Exam')->pluck('id','category_name');
        return view('admin.online_course.create',compact('category'));
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
            'category'=>'required',
            'course_name'=>'required|max:150|unique:online_courses',
            'course_description'=>'required',
            'course_duration'=>'required',
            'course_code'=>'required',
            'course_fee'=>'required|numeric',
            'pdf' => 'nullable|mimes:pdf|max:10000',
            'exam_link'=>'nullable'
        ]);

         if ($request->hasFile('pdf')){
        $path = Storage::disk('public')->put('online_course_pdf', $request->file('pdf'));
       }

        $course = new OnlineCourse;
        $course->category_id = $request->category;
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->slug = Str::slug($request->course_name , '-');
        $course->course_description = $request->course_description;
        $course->course_duration = $request->course_duration;
        $course->course_fee = $request->course_fee;
        if ($request->hasFile('pdf')){
        $course->pdf = $path;
    }
        $course->exam_link = $request->exam_link;
        // $course->status = $request->status;
        $course->save();

        Toastr::success('Online Course Successfully Created', 'Success');
     return redirect(route('online-course.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getdata()
    {
        $course = OnlineCourse::select('online_courses.*','categories.category_name as category')
        ->join('categories','online_courses.category_id','categories.id')
        ->get();
        return Datatables::of($course)->addColumn('edit', function ($course) {
               return '<a href="'.route('online-course.edit',$course->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($course) {
               return '<span data-url="'.route('online-course.destroy',$course->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
           })->rawColumns(['edit','action'])
        ->addIndexColumn()
        ->make(true);
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = OnlineCourse::findOrFail($id);
        $category = Categories::withTrashed()->where('type','!=','Exam')->pluck('id','category_name');
        return view('admin.online_course.edit',compact('course','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'category'=>'required',
            'course_name'=>'required|unique:online_courses,course_name,'.$id,
            'course_description'=>'required',
            'course_duration'=>'required',
            'course_fee'=>'required',
            'pdf' => 'nullable|mimes:pdf|max:10000',
            'exam_link'=>'nullable'
        ]);

         if ($request->hasFile('pdf')){
        $path = Storage::disk('public')->put('online_course_pdf', $request->file('pdf'));
       }

        $course = OnlineCourse::findOrFail($id);
        $course->category_id = $request->category;
        $course->course_name = $request->course_name;
        $course->slug = Str::slug($request->course_name , '-');
        $course->course_description = $request->course_description;
        $course->course_duration = $request->course_duration;
        $course->course_fee = $request->course_fee;
         if ($request->hasFile('pdf')){
        $course->pdf = $path;
    }
        $course->exam_link = $request->exam_link;
        // $course->status = $request->status;
        $course->save();

        Toastr::success('Online Course Successfully Updated', 'Success');
     return redirect(route('online-course.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OnlineCourse::findOrFail($id)->delete();
        Toastr::error('Online Course Successfully Removed', 'Success');
        return redirect()->back();
    }


    public function getCourseByCategory($id)
    {
        $course = OnlineCourse::where('category_id', $id)->pluck('course_name','id');
        $courses = '';

        foreach ($course as $key => $value) {
            $courses .= '<option value="'.$key.'">'.$value.'</option>';
        };

        return $courses;
    }

    public function viewDeletedCourses()
    {
        return view('admin.online_course.deleted_courses');
    }

    public function getDeletedCoursesData()
    {
        $course = OnlineCourse::onlyTrashed()
        ->select('online_courses.*','categories.category_name as category')
        ->join('categories','online_courses.category_id','categories.id')
        ->get();
        return Datatables::of($course)
        ->addColumn('restore', function ($course) {
               return '<span data-url="'.route('online-course.restore',$course->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        OnlineCourse::withTrashed()->find($id)->restore();
        return redirect(route('online-course.index'));
    }

    public function courseStudents(Request $request)
    {
        $date = Carbon::now();

        $study_center = Centers::pluck('id','study_center_name');
        $course = OnlineCourse::pluck('id','course_name');

    if($request->study_center != null){
    if($request->study_center != null && $request->course != null && $request->type == 'active students' && $request->exam_date != null){
         $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration','student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['center_online_courses.course_id','=',$request->course],['student_courses.result','=',null],['student_courses.exam_date','=',$request->exam_date],['student_courses.deleted_at','=',null]])
            ->whereRaw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) >= NOW()')
            ->get();
        $certificate = '0';
    }
    elseif($request->study_center != null && $request->course != null && $request->type == 'completed students' && $request->exam_date != null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration','student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.exam_date','=',$request->exam_date],['center_online_courses.course_id','=',$request->course],['student_courses.result','=','pass'],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '1';
        }
        if($request->study_center != null && $request->course == null && $request->type == 'active students' && $request->exam_date != null){
         $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.result','=',null],['student_courses.exam_date','=',$request->exam_date],['student_courses.deleted_at','=',null]])
            ->whereRaw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) >= NOW()')
            ->get();
        $certificate = '0';
    }
    elseif($request->study_center != null && $request->course == null && $request->type == 'completed students' && $request->exam_date != null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.exam_date','=',$request->exam_date],['student_courses.result','=','pass'],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '1';
        }
        if($request->study_center != null && $request->course != null && $request->type == 'active students' && $request->exam_date == null){
         $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['center_online_courses.course_id','=',$request->course],['student_courses.result','=',null],['student_courses.deleted_at','=',null]])
            ->whereRaw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) >= NOW()')
            ->get();
        $certificate = '0';
    }
    elseif($request->study_center != null && $request->course != null && $request->type == 'completed students' && $request->exam_date == null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['center_online_courses.course_id','=',$request->course],['student_courses.result','=','pass'],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '1';
        }
        if($request->study_center != null && $request->course == null && $request->type == 'active students' && $request->exam_date == null){
         $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.result','=',null],['student_courses.deleted_at','=',null]])
            ->whereRaw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) >= NOW()')
            ->get();
        $certificate = '0';
    }
    elseif($request->study_center != null && $request->course != null && $request->type == 'completed students' && $request->exam_date == null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')

            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.result','=','pass'],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '1';
        }
        elseif($request->study_center != null && $request->course != null && $request->type == null && $request->exam_date != null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')

            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['center_online_courses.course_id','=',$request->course],['student_courses.exam_date','=',$request->exam_date],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '0';
        }
        elseif($request->study_center != null && $request->course != null && $request->type == null && $request->exam_date == null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')

            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['center_online_courses.course_id','=',$request->course],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '0';
        }
        elseif($request->study_center != null && $request->course == null && $request->type == null && $request->exam_date != null){
            // completed students
           $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')

            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.exam_date','=',$request->exam_date],['student_courses.deleted_at','=',null]])
            ->get();

            $certificate = '0';
        }
        elseif($request->study_center != null && $request->course == null && $request->type == null && $request->exam_date == null){

        $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration', 'student_register_numbers.register_number as st_reg_number')
            ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
            ->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')

            ->join('online_courses','center_online_courses.course_id','online_courses.id')
            ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.deleted_at','=',null]])
            ->get();

        $certificate = '0';
      }

        // if($request->type == 'dropped students'){
        //     // dropped students
        //     $students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name')
        //     ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        //     ->join('online_courses','center_online_courses.course_id','online_courses.id')
        //     ->where([['center_online_courses.center_id','=',$request->study_center],['student_courses.result','!=','pass']])
        //     ->orwhere(DB::raw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) < NOW()'))
        //     ->get();
        //     $certificate = '0';
        // }

        // return Datatables::of($students)->addColumn('download', function ($download) {
        //        return '<a href="'.route('online_course_certificate',$students->id).'" class="btn btn-info btn-fw">Download</a>';
        //    })->rawColumns(['download'])
        // ->addIndexColumn()
        // ->make(true);
      }else{
        $students = Collect();
        $certificate = '0';
      }

      return view('admin.online_course.course_students',compact('students','study_center','certificate','course'));

    }

    public function courseCertificate($id)
    {
        $certificate = Certificates::where([['student_id','=',$id]])->first();

       if($certificate == null){
        Toastr::error('No Certificate Found', 'Not Found');
        return redirect()->back();
       }

        $publish_result = StudentCourse::findOrFail($id);

        if($publish_result->result == 'fail'){
            Toastr::error('Failed In Exam  !!Better Luck Next Time!!', 'Error');
            return redirect()->back();
        }

       $customPaper = array(0,0,720,900);
       $pdf = PDF::loadView('admin.online_course.certificate',compact('certificate'))->setPaper($customPaper,'portrait');
        return $pdf->download('certificate.pdf');
    }

    public function getCourseByCenter($id)
    {
        $course = CenterOnlineCourse::where('center_online_courses.center_id', $id)
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->pluck('online_courses.course_name','online_courses.id');
        $courses = '';

        foreach ($course as $key => $value) {
            $courses .= '<option value="'.$key.'">'.$value.'</option>';
        };

        return $courses;
    }

    public function changeStudentStatus($id)
    {
        $student = StudentCourse::findOrFail($id);

        if($student->status == '1'){
            $student->status = "0";
            $student->save();
        }
        else
        {
            $student->status = "1";
            $student->save();
        }

        Toastr::success('Status Updated', 'success');
        return redirect()->back();
    }

    public function removeStudent($id)
    {
        $student = StudentCourse::findOrFail($id);

        $center_online_course = CenterOnlineCourse::where('center_online_courses.id','=',$student->center_online_courses_id)
        ->first();
        $center_online_course->limit = $center_online_course->limit+1;
        $center_online_course->save();

        if($student == null){
            return abort(404);
        }
        $student->delete();

        Toastr::error('Successfully Removed', 'success');
        return redirect()->back();
    }
    
    public function studentcreate(Request $request)
    {
        $courses = OnlineCourse::all(); 
        return view('admin.student.create', compact('courses'));
    }
    
    public function onlinestudentregister(Request $request)
   { 
    $request->validate([
        'course_id' => 'required|exists:online_courses,id',
        'name' => 'required',
        'email' => 'required|email',
        'mobile' => 'required|numeric',
        'dob' => 'required|date',
        'gender' => 'required',
        'address' => 'required',
        'father_name' => 'required|string|max:255',
        'passout_year' => 'required|digits:4',
        'passout_month' => 'required|digits:2',
         
        
    ]); 

    $passoutYearMonth = $request->passout_year . '-' . $request->passout_month;

    // Get course and code
    $course = OnlineCourse::find($request->course_id);
    $courseCode = $course->course_code; // eg: 'DIF'

    // Generate register number like DIFC01825
    $randomNum = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT); // 01 to 99
    $year = sprintf('%02d', (int)$request->passout_year % 100);  
    $registerNumber = $courseCode . $randomNum . $year;

   
    
     $idProofPath = $request->hasFile('id_proof')
        ? $request->file('id_proof')->store('id_proofs', 'public')
        : null;

    $imagePath = $request->hasFile('image')
        ? $request->file('image')->store('student_images', 'public')
        : null;
    
   

    // Save student
    $student = new StudentCourse();
    $student->center_online_courses_id = $request->course_id;
    $student->name = $request->name;
    $student->email = $request->email;
    $student->mobile = $request->mobile;
    $student->dob = $request->dob;
    $student->gender = $request->gender;
    $student->address = $request->address;
    $student->father_name = $request->father_name;
    $student->passout_year_month = $passoutYearMonth;
    $student->register_number = $registerNumber;
    $student->id_proof = $idProofPath;
    $student->image = $imagePath;
    $student->save();

    // Send confirmation email
     
     Mail::to($student->email)->send(new \App\Mail\StudentRegisteredMail($student));


    return redirect()->route('online.student.registerlist')->with('success', 'Student registered successfully!');

}
    public function registerlist()
    {
         $registrations = DB::table('student_courses')
        ->join('online_courses', 'student_courses.center_online_courses_id', '=', 'online_courses.id')
        ->whereNull('student_courses.deleted_at') 
        ->select(
            'student_courses.id',
            'student_courses.name as student_name',
            'student_courses.email',
            'student_courses.mobile',
            'student_courses.register_number',
            'online_courses.course_name'
        )
        ->orderBy('student_courses.id', 'desc')
        ->get();
    
        return view('admin.student.index', compact('registrations'));
    }
    
    
    public function registeredit($id)
{
    $student = StudentCourse::findOrFail($id);
    $courses = OnlineCourse::all(); 

    return view('admin.student.edit', compact('student', 'courses'));
}
    
    public function registerupdate(Request $request, $id)
{
    $student = StudentCourse::findOrFail($id);

    $request->validate([
        'course_id' => 'required',
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'mobile' => 'required',
        'dob' => 'required|date',
        'gender' => 'required',
        'address' => 'required|string',
        'father_name' => 'required|string|max:255',
        'passout_year' => 'required|digits:4',
        'passout_month' => 'required|digits:2',
        
        
    ]);


    $student->center_online_courses_id = $request->course_id;
    $student->name = $request->name;
    $student->email = $request->email;
    $student->mobile = $request->mobile;
    $student->dob = $request->dob;
    $student->gender = $request->gender;
    $student->address = $request->address;
    $student->father_name = $request->father_name;
    $student->passout_year_month = $request->passout_year . '-' . $request->passout_month;

   

    if ($request->hasFile('id_proof')) {
        $student->id_proof = $request->file('id_proof')->store('id_proofs', 'public');
    }

    if ($request->hasFile('image')) {
        $student->image = $request->file('image')->store('images', 'public');
    }

    $student->save();

    return redirect()->route('online.student.registerlist')->with('success', 'Student updated successfully!');
}

   public function registerdestroy($id)
{
    $student = StudentCourse::findOrFail($id); 

    // Just soft delete — don't remove any files
    $student->delete();

    return redirect()->route('online.student.registerlist')
                     ->with('success', 'Student soft deleted successfully!');
}
    
    
        public function certificatecomplete(Request $request)
    {  
        $student = StudentCourse::findOrFail($request->student_id); 
        $courseId = $student->center_online_courses_id;
        
        $course = OnlineCourse::find($courseId);



        $courseName = $course ? $course->course_name : 'Unknown';
    
        // Prevent duplicate certificate entry
        if (Certificates::where('student_id', $student->id)->exists()) {
            return redirect()->back()->with('success', 'Certificate already processed for this student.');
        }
    
        $centerName = 'Main Center'; // replace with actual value if available
    $examMarksId = 1;            // replace with actual logic
    $totalMark = 100;            // fixed or fetched based on course
    $scored = 95.50;             // replace with logic if needed

    // Insert certificate
    Certificates::create([
        'certificate_id'    => $student->register_number, // generates unique cert ID
        'exam_marks_id'     => $examMarksId,
        'student_id'        => $student->id,
        'student_name'      => $student->name,
        'center_name'       => $centerName,
        'course_name'       => $course->course_name,
        'date_of_awarded'   => Carbon::now(),
        'total_mark_scored' => $scored,
        'total_mark'        => $totalMark,
    ]);

    
        return redirect()->back()->with('success', 'Certification process successfully completed!');
    }
    
    public function ajaxSearch(Request $request)
{
    $query = DB::table('student_courses')
        ->join(
            'online_courses',
            'student_courses.center_online_courses_id',
            '=',
            'online_courses.id'
        )
        ->whereNull('student_courses.deleted_at')            // keep soft‑delete filter
        ->select(
            'student_courses.id',
            'student_courses.name as student_name',          // 👈 alias!
            'student_courses.email',
            'student_courses.mobile',
            'student_courses.register_number',
            'online_courses.course_name'
        );

    if ($request->filled('search')) {
        $query->where('student_courses.name', 'like', '%'.$request->search.'%');
    }

    // paginate so you don’t bring back thousands of rows at once
    $registrations = $query->orderBy('student_courses.id', 'desc')->paginate(10);

    return view('admin.student.index', compact('registrations'));
}

    
}

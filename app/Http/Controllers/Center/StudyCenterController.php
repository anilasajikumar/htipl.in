<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Mail\IncreaseLimitMail;
use App\Mail\StudentPasswordSendMail;
use App\Models\CenterOnlineCourse;
use App\Models\Centers;
use App\Models\Certificates;
use App\Models\Downloads;
use App\Models\LimitValidityRequest;
use App\Models\OnlineCourse;
use App\Models\StudentCourse;
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

class StudyCenterController extends Controller
{

	public function index()
	{
		return view('center.home');
	}
    /**
	*Show Change Password Form.
	*
	*@return \Illuminate\Http\Response
	*/

	public function changePasswordForm()
	{
		return view('center.settings.change_password');
	}

	/**
	*change Password For Centers.
	*
	*@return \Illuminate\Http\Response
	*/

	public function changePassword(Request $request)
	{
		$this->validate($request, [
        'password' => 'required |confirmed| min:6 | max:12',
     ]);
    
        $center = Centers::find(Auth::guard('center')->user()->id);
        $center->password = Hash::make($request['password']);
        $center->save();

        Toastr::success('Password Successfully Changed', 'Success');
        return Redirect(route('study-centers'));
	}

	public function myCourses()
	{
		return view('center.my_course');
	}

	public function getMyCourseData()
	{
		$center_course = CenterOnlineCourse::select('center_online_courses.*','online_courses.course_name','online_courses.slug')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where('center_online_courses.center_id','=',Auth::guard('center')->user()->id)
        ->withCount('studentCourse')
        ->get();

        return Datatables::of($center_course)->addColumn('request', function ($center_course) {
               return '<a href="'.route('increase_limit_form',$center_course->slug).'">Increase Limit/Validity</a>';
           })->addColumn('register', function ($center_course) {
               return '<a href="'.route('enroll.student').'" class="btn btn-info btn-fw">Register</a>';
           })
        ->rawColumns(['register','request'])
        ->addIndexColumn()
        ->make(true);
	}

	public function increaseLimitForm($slug)
	{
		$center_course = CenterOnlineCourse::select('center_online_courses.*','online_courses.course_name','online_courses.slug')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where([['online_courses.slug','=',$slug],['center_online_courses.center_id','=',Auth::guard('center')->user()->id]])
        ->first();

        if($center_course == null){

        	return abort(404);
        }

        return view('center.increase_limit',compact('center_course'));
	}

	public function increaseLimit(Request $request)
	{
		$this->validate($request,[
			'center_course_id'=>'required',
			'course_name'=>'required'
		]);

		$old = CenterOnlineCourse::findOrFail($request->center_course_id);

		$send_request = new LimitValidityRequest;
		$send_request->center_online_courses_id = $request->center_course_id;
		$send_request->new_validity = $request->validity;
		$send_request->new_limit = $request->limit;
		$send_request->old_validity = $old->validity;
		$send_request->old_limit = $old->limit;
		$send_request->save();

		$course = CenterOnlineCourse::select('online_courses.course_name','center_online_courses.*')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
		->where("center_online_courses.id",'=',$request->center_course_id)
		->first();

		$mail = env('TO_MAIL');
        try{
        Mail::to($mail)->send(new IncreaseLimitMail($course));
        }
        catch(Exception $e){
            Toastr::success('Successfully Created', 'Success');
            return redirect(route('study-center-exam.index'));
        }

		Toastr::success('Request Successfully Send', 'Success');
		return redirect(route('my_course'));
	}

	public function enrollCourseStudents($slug)
	{
		$center_course = CenterOnlineCourse::select('center_online_courses.*','online_courses.course_name','online_courses.slug')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where([['online_courses.slug','=',$slug],['center_online_courses.center_id','=',Auth::guard('center')->user()->id]])
        ->first();

        if($center_course == null){
        	return abort(404);
        }

        return view('center.enroll_students',compact('center_course'));
	}

	public function enrollStudent()
	{
		$active_courses = CenterOnlineCourse::select('center_online_courses.*','online_courses.course_name','online_courses.slug')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where('center_online_courses.center_id','=',Auth::guard('center')->user()->id)
        ->where('center_online_courses.limit','>',0)
        ->where('center_online_courses.validity','>=',Carbon::today()->toDateString())
        ->get();

        return view('center.enroll_student_multi', compact('active_courses'));
	}


	public function registerStudents(Request $request)
	{
		$this->validate($request,[
			'course_ids'   => 'required|array|min:1',
			'course_ids.*' => 'exists:center_online_courses,id',
			'name'         => 'required',
			'email'        => 'required|email',
			'mobile'       => 'required|min:6|max:16',
			'dob'          => 'required',
			'gender'       => 'required',
			'exam_date'    => 'required',
			'id_proof'     => 'required|mimes:pdf',
			'image'        => 'mimes:jpeg,jpg,png,gif|required|max:2128',
			'address'      => 'required|max:255',
		]);

		$path  = $request->hasFile('image')   ? Storage::disk('public')->put('student_image', $request->file('image'))  : null;
		$path2 = $request->hasFile('id_proof') ? Storage::disk('public')->put('student_proof', $request->file('id_proof')) : null;

		$password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 8)), 0, 8);
		$enrollments = []; // collect all enrolled records for the email

		foreach ($request->course_ids as $center_online_course_id) {
			$center_online_course = CenterOnlineCourse::with('onlineCourse')
				->where('id', $center_online_course_id)
				->where('center_id', Auth::guard('center')->user()->id)
				->first();

			if (!$center_online_course || $center_online_course->limit == 0) {
				continue;
			}

			$latest = StudentCourse::withTrashed()->orderBy('id','desc')->first();
			$register_number = $latest ? ++$latest->register_number : "HTIO1098";

			$course_students = new StudentCourse;
			$course_students->center_online_courses_id = $center_online_course->id;
			$course_students->register_number = $register_number;
			$course_students->name            = $request->name;
			$course_students->email           = $request->email;
			$course_students->mobile          = $request->mobile;
			$course_students->dob             = $request->dob;
			$course_students->gender          = $request->gender;
			$course_students->address         = $request->address;
			$course_students->exam_date       = $request->exam_date;
			$course_students->image           = $path;
			$course_students->id_proof        = $path2;
			$course_students->password        = Hash::make($password);
			$course_students->status          = "0";
			$course_students->save();

			$center_online_course->decrement('limit');

			$enrollments[] = [
				'course_name'     => optional($center_online_course->onlineCourse)->course_name ?? '',
				'register_number' => $register_number,
			];
		}

		if (!empty($enrollments)) {
			try {
				Mail::to($request->email)->send(new StudentPasswordSendMail(
					(object)['name' => $request->name, 'email' => $request->email],
					$password,
					$enrollments
				));
			} catch (\Exception $e) {
				\Log::error('Student welcome email failed: ' . $e->getMessage());
			}
		}

		Toastr::success('Student registered successfully.', 'Success');

     return redirect(route('my_course'));
	}


	public function activeStudents()
	{
	   $course = OnlineCourse::pluck('id','course_name');
	   	$students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration','student_register_numbers.register_number as st_reg_number')
		->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
			->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
		->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.result','=',null],['student_courses.deleted_at','=',null]])
		->whereRaw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) >= NOW()')
		->when(request()->course ?? null, function($q){
			$q->where('center_online_courses.course_id','=',request()->course);
		})
		->when(request()->exam_date ?? null, function($q){
			$q->where('student_courses.exam_date','=',request()->exam_date);
		})
		->get();
		
		return view('center.course.active_students',compact('course','students'));
	}


	public function activeStudentsData()
	{
        $date = Carbon::now();
		$students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration','student_register_numbers.register_number as st_reg_number')
		->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
		->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
		->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.result','=',null],['student_courses.deleted_at','=',null]])
		->whereRaw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) >= NOW()')
		->get();

		 return Datatables::of($students)->addColumn('change-password', function ($students) {
               return '<a href="'.route('student.password',$students->id).'" class="btn btn-dark btn-fw">Change Password</a>';
           })->addColumn('id_proof', function ($students) {
               return '<a href="'.asset('/storage/'.$students->id_proof).'" download><button class="btn btn-warning">ID Proof Download</button></a>';
           })->addColumn('file', function ($students) {
               return '<a href="'.route('center_student_files',$students->id).'" class="btn btn-info btn-fw">Upload File</a>';
           })
		 ->addColumn('register_no', function ($students) {
               return '<a href="'.route('edit_student_register',$students->id).'" class="btn btn-primary btn-fw">REG NO.</a>';
           })->rawColumns(['change-password','id_proof','file','register_no'])
        ->addIndexColumn()
        ->make(true);
	}


	public function studentPassword($id)
	{
		$student_id = $id;
        return view('center.course.change_password',compact('student_id'));
	}

	public function changestudentPassword(Request $request, $id)
	{
		$this->validate($request, [
        'password' => 'required|confirmed|min:6|max:12',
     ]);
    
        $center = StudentCourse::findOrFail($id);
        $center->password = Hash::make($request['password']);
        $center->save();

        Toastr::success('Password Successfully Changed', 'Success');
        return Redirect(route('active_students'));
	}

	public function completedStudents()
	{
	    $course = OnlineCourse::pluck('id','course_name');
			$students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name', 'student_register_numbers.register_number as st_reg_number')
		->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
				->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')
		->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.result','=','pass'],['student_courses.deleted_at','=',null]])
		->when(request()->course ?? null, function($q){
			$q->where('center_online_courses.course_id','=',request()->course);
		})
		->when(request()->exam_date ?? null, function($q){
			$q->where('student_courses.exam_date','=',request()->exam_date);
		})
		->get();
		return view('center.course.completed_students', compact('course','students'));
	}


	public function completedStudentsData()
	{
		$students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','student_register_numbers.register_number as st_reg_number')
		->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
						->leftJoin('student_register_numbers','student_register_numbers.student_courses_id','student_courses.id')

		->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.result','=','pass'],['student_courses.deleted_at','=',null]])
		->get();

		return Datatables::of($students)->addColumn('id_proof', function ($students) {
               return '<a href="'.asset('/storage/'.$students->id_proof).'" download><button class="btn btn-warning">ID Proof Download</button></a>';
           })->addColumn('download', function ($students) {
			if($students->result == 'fail'){
				return '';
			}
			else{
               return '<a href="'.route('students.certificate',$students->id).'" class="btn btn-info btn-fw">Download</a>';
			}
           })->rawColumns(['id_proof','download'])
        ->addIndexColumn()
        ->make(true);

	}

	public function StudentsCertificate($id)
	{
		$certificate = Certificates::where([['student_id','=',$id],['center_name','=',Auth::guard('center')->user()->study_center_name]])->first();

       if($certificate == null){
        Toastr::error('No Certificate Found', 'Not Found');
        return redirect()->back();
       }

       $publish_result = CenterOnlineCourse::select('student_courses.*','online_courses.course_name','online_courses.course_duration')
		->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
		->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.id','=',$id],['student_courses.deleted_at','=',null]])
		->first();

        // $publish_result = StudentCourse::findOrFail($id);

        if($publish_result->result == 'fail'){
            Toastr::error('Failed In Exam  !!Better Luck Next Time!!', 'Error');
            return redirect()->back();
        }

       $customPaper = array(0,0,720,900);
       $pdf = PDF::loadView('center.course.certificate',compact('certificate'))->setPaper($customPaper,'portrait');
        return $pdf->download('certificate.pdf');
	}

	public function droppedStudents()
	{
		return view('center.course.dropped_students');
	}


	public function droppedStudentsData()
	{
		$students = CenterOnlineCourse::select('student_courses.*','online_courses.course_name')
		->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
		->join('online_courses','center_online_courses.course_id','online_courses.id')
		->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.result','!=','pass'],['student_courses.deleted_at','=',null]])
		->orwhere(DB::raw('DATE_ADD(student_courses.created_at, INTERVAL online_courses.course_duration DAY) < NOW()'))
		->get();

		 return Datatables::of($students)->make(true);
	}

	public function downloadsFiles()
	{
		return view('center.downloads.index');
	}

	public function downloadsFilesData()
	{
		$download = Downloads::select('downloads.*')->get();

        return Datatables::of($download)->addColumn('download', function ($download) {
               return '<a href="'.route('downloads.files',$download->id).'" class="btn btn-info btn-fw">Download</a>';
           })->rawColumns(['download'])
        ->addIndexColumn()
        ->make(true);
	}

	public function downloadsFile($id)
	{
		$download = Downloads::findOrFail($id);
        return Storage::disk('public')->download($download->pdf, 'file.pdf');
	}
}

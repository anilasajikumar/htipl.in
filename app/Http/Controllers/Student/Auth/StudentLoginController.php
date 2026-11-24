<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Models\StudentCourse;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Toastr;
use DB;

class StudentLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('student.redirect');
    }

    public function showLoginForm()
    {
    	return view('auth.student-login');
    }

    public function login(Request $request)
    {

        $this->validate($request,[
            'register_number'   => 'required',
            'password' => 'required',
          ]);

        // find expired
        $date = Carbon::now();
        $check_course_validity = StudentCourse::select('center_online_courses.*','online_courses.course_duration','student_courses.created_at as reg_date')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where([['student_courses.register_number','=',$request->register_number]])
        ->first();

        if($check_course_validity == null){

        return redirect()->back()->withErrors(['email' => 'Invalid Register Number or Password.'])->withInput($request->only('email', 'remember'));
       }

        if((new Carbon($check_course_validity->reg_date))->addDays($check_course_validity->course_duration) < $date ){
            $check_course_validity = null;
        }

        if($check_course_validity == null){
        return redirect()->back()->withErrors(['email' => 'Course Validity Expired'])->withInput($request->only('email', 'remember'));
        }

        
      if (Auth::guard('student')->attempt(['register_number' => $request->register_number, 'password' => $request->password, 'status' => '1'], $request->remember)) {

        Toastr::success('Successfully Logged In', 'success',["positionClass" => "toast-top-center"]);
        Toastr::info('Logged In as student', 'welcome',["positionClass" => "toast-top-center"]);

        return redirect()->intended(route('student-home'));
      }
      else{
      
      return redirect()->back()->withErrors(['email' => 'Invalid Register Number or Password.'])->withInput($request->only('email', 'remember'));
    }
}
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudentCourse;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use JWTAuthException;

class UserAuthController extends Controller
{
   public function __construct()
    {
        $this->middleware('student.redirect');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('register_number', 'password');
        $token = null;
        try {
           
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                     'status' => false,
                    'message' => 'Invalid Email Or Mobile Or Password',
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                 'status' => false,
                'message' => 'Failed To Create Token',
            ]);
        }

        $date = Carbon::now();
        $check_course_validity = StudentCourse::select('center_online_courses.*','online_courses.course_duration','student_courses.created_at as reg_date')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where([['student_courses.register_number','=',$request->register_number]])
        ->first();

        if($check_course_validity == null){

        return response()->json([
            'status' => false,
            'message' => 'Invalid Email Or Mobile Or Password',
        ]);

       }

       if((new Carbon($check_course_validity->reg_date))->addDays($check_course_validity->course_duration) < $date ){
            $check_course_validity = null;
        }

        if($check_course_validity == null){
            return response()->json([
            'status' => false,
            'message' => 'Course Validity Expired',
        ]);
        }

        if (Auth::guard('student')->attempt(['register_number' => $request->register_number, 'password' => $request->password, 'status' => '1'], $request->remember)) {

            return response()->json([
            
            'result' => [
                'student' => $check_course_validity,
                'token' => $token,
            ],
            'status' => true,
            'message' => 'success',
        ]);
      }
      else{
        return response()->json([
            'status' => false,
            'message' => 'Course Validity Expired',
        ]);
    }
    
    }


    public function profile()
    {
        $student = StudentCourse::select('student_courses.name','student_courses.email','student_courses.mobile','student_courses.register_number','student_courses.image','student_courses.gender','student_courses.exam_date','online_courses.course_duration','student_courses.created_at as reg_date')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where([['student_courses.register_number','=',Auth::user()->register_number]])
        ->first();

        return response()->json([
            
            'result' => [
                'student' => $student,
            ],
            'status' => true,
            'message' => 'success',
        ]);
    }


    public function changePassword(Request $request)
    {
      $id = Auth::user()->id;
      $this->validate($request,[
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

        $user = StudentCourse::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

         $response = array(
        'status' => true,
        'message' => 'success',
    );
    return response()->json($response, 200);

    }

}

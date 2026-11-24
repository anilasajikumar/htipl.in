<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\CenterRequestSendMail;
use App\Mail\StudentEnquiryToCenter;
use App\Models\Categories;
use App\Models\CenterOnlineCourse;
use App\Models\Centers;
use App\Models\OnlineCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashBoardController extends Controller
{
    public function CourseCategory()
    {
        $categories = Categories::where('status','=','1')
        ->get();

        if($categories->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }
        else{
        $data = ['data'=>['categories'=>$categories],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
        }
    }

    public function CourseByCategory(Request $request)
    {
        $this->validate($request,[
            'category_id'=>'required'
        ]);

         $course = OnlineCourse::where([['status','=','1'],['category_id','=',$request->category_id]])->get();

         if($course->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }
        else{
        $data = ['data'=>['course'=>$course],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
        }
    }

    public function courseDetails(Request $request)
    {
        $this->validate($request,[
            'slug'=>'required'
        ]);

        $course = OnlineCourse::where([['status','=','1'],['slug','=',$request->slug]])->first();

        if($course == null){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }
        else{
        $data = ['data'=>['course'=>$course],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
        }
    }

    public function Enquiry(Request $request)
    {
        $this->validate($request,[
          'name' => 'required',
          'email' => 'required',
          'contact_number' => 'required',
          'center' => 'required',
          'course' => 'required',
          'message' => 'required'
    ]);
        $center = Centers::findOrFail($request->center);
        $course = OnlineCourse::findOrFail($request->course);

        try{
        $mail = env('TO_MAIL');
        Mail::to($mail)->send(new CenterRequestSendMail($request,$course->course_name,$center->study_center_name));
       }
       catch (\Exception $e){
        $responses = array(
                'status' => true,
                'message' => 'Mail Error, Please Try Again Later',
            );
        return response()->json($responses, 200);
       }

       try{
        $send_to_mail = $center->study_center_email;
        Mail::to($send_to_mail)->send(new StudentEnquiryToCenter($request,$course->course_name,$center->study_center_name));
        }
       catch (\Exception $e){
        $responses = array(
                'status' => true,
                'message' => 'Mail Error, Please Try Again Later',
            ); 
        return response()->json($responses, 200);
       }

         $responses = array(
                'status' => true,
                'message' => 'Success',
            ); 
        return response()->json($responses, 200);
    }

    public function Centers()
    {
        $centers = Centers::select('centers.id','centers.logo','centers.study_center_address','centers.study_center_name','centers.study_center_email','centers.study_center_mobile')
        ->where('status','=','1')
        ->get();

         $data = ['data'=>['centers'=>$centers],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);

    }

    public function CourseByCenter(Request $request)
    {
        $this->validate($request,[
            'center_id'=>'required',
        ]);
        
        $course = CenterOnlineCourse::select('online_courses.course_name','online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->where('center_online_courses.center_id', $request->center_id)
        ->get();

        if($course->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }
        else{

        $data = ['data'=>['course'=>$course],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
        }
    }
}

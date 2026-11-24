<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\CenterRequestSendMail;
use App\Mail\StudentEnquiryToCenter;
use App\Models\Alert;
use App\Models\Categories;
use App\Models\CourseMedia;
use App\Models\CourseModule;
use App\Models\Files;
use App\Models\StudentCourse;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function Modules()
    {
        $modules = StudentCourse::select('course_modules.*')
        ->join('center_online_courses','student_courses.center_online_courses_id','center_online_courses.id')
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->join('course_modules','online_courses.id','course_modules.course_id')
        ->where([['student_courses.register_number','=',Auth::user()->register_number],['course_modules.deleted_at','=',null]])
        ->orderBy('course_modules.created_at','asc')
        ->get();

        if($modules->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }
        else{
        $data = ['data'=>['modules'=>$modules],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
        }
    }

    public function getAllVideoMedias(Request $request)
    {
        $this->validate($request,[
            'course_module_id' => 'required'
        ]);

        $course_media = CourseMedia::select('course_media.course_module_id','media.*','course_media.course_media_description')
        ->join('media','course_media.id','media.course_media_id')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('online_courses','course_modules.course_id','online_courses.id')
        ->join('center_online_courses','online_courses.id','center_online_courses.course_id')
        ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        ->where([['course_media.course_module_id','=',$request->course_module_id],['student_courses.register_number','=',Auth::user()->register_number],['media.extension','!=','pdf']])
        ->orderBy('media.id','asc')
        ->get();

        if($course_media->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
            return response()->json($responses, 200);
        }

        $data = ['data'=>['media'=>$course_media],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
    }


    public function getAllPdfMedias(Request $request)
    {
        $this->validate($request,[
            'course_module_id' => 'required'
        ]);

        $course_media = CourseMedia::select('course_media.course_module_id','media.*','course_media.course_media_description')
        ->join('media','course_media.id','media.course_media_id')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('online_courses','course_modules.course_id','online_courses.id')
        ->join('center_online_courses','online_courses.id','center_online_courses.course_id')
        ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        ->where([['course_media.course_module_id','=',$request->course_module_id],['student_courses.register_number','=',Auth::user()->register_number],['media.extension','=','pdf']])
        ->orderBy('media.id','asc')
        ->get();

        if($course_media->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }

        $data = ['data'=>['media'=>$course_media],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
    }


     public function getAllMediaLinks(Request $request)
    {
        $this->validate($request,[
            'course_module_id' => 'required'
        ]);

        $course_media = CourseMedia::select('course_media.course_module_id','media_links.*','course_media.course_media_description')
        ->join('media_links','course_media.id','media_links.course_media_id')
        ->join('course_modules','course_media.course_module_id','course_modules.id')
        ->join('online_courses','course_modules.course_id','online_courses.id')
        ->join('center_online_courses','online_courses.id','center_online_courses.course_id')
        ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        ->where([['course_media.course_module_id','=',$request->course_module_id],['student_courses.register_number','=',Auth::user()->register_number]])
        ->orderBy('media_links.order','asc')
        ->get();

        if($course_media->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }

        $data = ['data'=>['media'=>$course_media],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
    }

    public function getAlerts()
    {
        $alerts = Alert::select('alerts.*')->get();

        if($alerts->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }

        $data = ['data'=>['alerts'=>$alerts],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
    }

    public function getDownloads()
    {
        $files = Files::where('student_courses_id','=',Auth::user()->id)->get();

        if($files->isEmpty()){
            $responses = array(
                'status' => true,
                'message' => 'Empty',
            ); 
        return response()->json($responses, 200);
        }

        $data = ['data'=>['files'=>$files],'status'=>true,'message'=>'success'];

        return response()->json($data, 200);
    }

}

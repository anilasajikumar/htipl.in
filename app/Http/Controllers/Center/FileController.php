<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Models\CenterOnlineCourse;
use App\Models\Files;
use App\Models\StudentCourse;
use App\Models\StudentRegisterNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Toastr;
use Yajra\Datatables\Datatables;
use Auth;

class FileController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('center.file.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    	$student_id = CenterOnlineCourse::select('student_courses.*')
        ->join('student_courses','center_online_courses.id','student_courses.center_online_courses_id')
        ->where([['center_online_courses.center_id','=',Auth::guard('center')->user()->id],['student_courses.id','=',$id]])
        ->first();

    	if($student_id == null){
    		return abort(404);
    	}
    	// $find_reg_number = StudentRegisterNumber::where('student_courses_id','=',$id)->first();
    	$files = Files::where('student_courses_id','=',$id)->get();
        return view('center.file.create',compact('student_id','files'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
         $this->validate($request, [
                'file' => 'required|mimes:pdf'
        ],['file' => 'The file must be a file of type: pdf.']);
        
        
        $name = $request->file('file')->getClientOriginalName();
        $request->file('file')->move(storage_path().'/app/public/student_files/', $name);  
  
        $downloads_file = new Files;
        $downloads_file->student_courses_id = $id;
        $downloads_file->title = $request->title;
        $downloads_file->pdf = 'student_files/'.$name;
        $downloads_file->save();

        // if($request->register_number != null){
        // 	$reg = new StudentRegisterNumber;
        // 	$reg->student_courses_id = $id;
        // 	$reg->register_number = $request->register_number;
        // 	$reg->save();
        // }

        Toastr::success('Successfully Created', 'Success');
        return redirect()->back();
    }

    public function studentRegister($id)
    {
        $student_id = StudentCourse::findOrFail($id);
        if($student_id == null){
            return abort(404);
        }
        $find_reg_number = StudentRegisterNumber::where('student_courses_id','=',$id)->first();
        
        return view('center.file.register_number',compact('student_id','find_reg_number'));
    }

    public function updateStudentRegister(Request $request, $id)
    {
        $this->validate($request, [
                'register_number' => 'required|unique:student_register_numbers,register_number,'.$id
        ]);
            $find_reg_number = StudentRegisterNumber::where('student_courses_id','=',$id)->first();
            if($find_reg_number == null){
            $reg = new StudentRegisterNumber;
            $reg->student_courses_id = $id;
            $reg->register_number = $request->register_number;
            $reg->save();
            }
            else
            {
                $find_reg_number->register_number = $request->register_number;
                $find_reg_number->save();
            }

            Toastr::success('Successfully Created', 'Success');
            return redirect()->back();
    }


}
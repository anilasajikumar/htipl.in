<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CourseModule;
use App\Models\OnlineCourse;
use Illuminate\Http\Request;
use Toastr;
use Yajra\Datatables\Datatables;

class CourseModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.course_module.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = OnlineCourse::where('status','=','1')->pluck('id','course_name');
        $category = Categories::where('type','!=','Exam')->pluck('id','category_name');
        return view('admin.course_module.create',compact('course','category'));
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
            'course_id' => 'required',
            'course_module_name' => 'required|max:255',
            'course_module_description' => 'required'
        ]);

        $course_module = new CourseModule;
        $course_module->course_id = $request->course_id;
        $course_module->course_module_name = $request->course_module_name;
        $course_module->course_module_description = $request->course_module_description;
        $course_module->save();

         Toastr::success('Successfully Created', 'Success');
     return redirect(route('course-module.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $course_module = CourseModule::select('course_modules.*','online_courses.course_name as course')
        ->join('online_courses','course_modules.course_id','online_courses.id')
        ->get();
        return Datatables::of($course_module)->addColumn('edit', function ($course_module) {
               return '<a href="'.route('course-module.edit',$course_module->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($course_module) {
               return '<span data-url="'.route('course-module.destroy',$course_module->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $course_module = CourseModule::findOrFail($id);
        $course = OnlineCourse::pluck('id','course_name');
        $selected_course = OnlineCourse::where('id','=',$course_module->course_id)->first();
        $category = Categories::where('type','!=','Exam')->pluck('id','category_name');

        return view('admin.course_module.edit',compact('course','course_module','category','selected_course'));
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
            'course_id' => 'required',
            'course_module_name' => 'required|max:255',
            'course_module_description' => 'required'
        ]);

        $course_module = CourseModule::findOrFail($id);
        $course_module->course_id = $request->course_id;
        $course_module->course_module_name = $request->course_module_name;
        $course_module->course_module_description = $request->course_module_description;
        $course_module->save();

         Toastr::success('Successfully updated', 'Success');
     return redirect(route('course-module.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CourseModule::findOrFail($id)->delete();
        Toastr::error('Successfully deleted', 'Success');
        return redirect()->back();
    }

    public function getModuleByCourse($id)
    {
        $course_modules = CourseModule::where('course_modules.course_id','=',$id)
        ->get();
        $course_module = '';

        foreach ($course_modules as $module) {
            $course_module .= '<option value="'.$module->id.'">'.$module->course_module_name.'</option>';
        };

        return $course_module;
    }
}

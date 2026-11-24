<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CenterOnlineCourse;
use App\Models\Centers;
use App\Models\Certificates;
use App\Models\CourseCalendar;
use App\Models\OnlineCourse;
use App\Models\StudentCourse;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;
use Toastr;
use Yajra\Datatables\Datatables;

class CourseCalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.course_calender.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin.course_calender.create');
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
            'course_name'=>'required|max:150',
            'starting_date'=>'required',
            'exam_date'=>'required',
            'location'=>'required',
        ]);

        $course = new CourseCalendar;
        $course->course_name = $request->course_name;
        $course->starting_date = $request->starting_date;
        $course->exam_date = $request->exam_date;
        $course->location = $request->location;
        $course->save();

        Toastr::success('Course Calender Successfully Created', 'Success');
        return redirect(route('course-calender.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getdata()
    {
        $course = CourseCalendar::select('course_calendars.*')
        ->get();
        return Datatables::of($course)->addColumn('edit', function ($course) {
               return '<a href="'.route('course-calender.edit',$course->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($course) {
               return '<span data-url="'.route('course-calender.destroy',$course->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
           })
        ->addColumn('starting_date', function($course) {
            return Carbon::parse($course->starting_date)->format('d-M-Y');
        })
        ->addColumn('exam_date', function($course) {
            return Carbon::parse($course->exam_date)->format('d-M-Y');
        })
        ->rawColumns(['edit','action','exam_date','starting_date'])
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
        $course_calender = CourseCalendar::findOrFail($id);
        
        return view('admin.course_calender.edit',compact('course_calender'));
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
            'course_name'=>'required',
            'starting_date'=>'required',
            'exam_date'=>'required',
            'location'=>'required',
        ]);

        $course = CourseCalendar::findOrFail($id);
        $course->course_name = $request->course_name;
        $course->starting_date = $request->starting_date;
        $course->exam_date = $request->exam_date;
        $course->location = $request->location;
        $course->save();

        Toastr::success('Course Calender Successfully Updated', 'Success');
     return redirect(route('course-calender.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CourseCalendar::findOrFail($id)->delete();
        Toastr::error('Course Calender Successfully Removed', 'Success');
        return redirect()->back();
    }

}

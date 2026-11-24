<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateCategories;
use App\Models\CorporateCourses;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;
use Toastr;
use Yajra\Datatables\Datatables;

class CorporateCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.corporate_course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $category = CorporateCategories::where('type','!=','Exam')->pluck('id','category_name');
        return view('admin.corporate_course.create',compact('category'));
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
            'course_name'=>'required|max:150|unique:corporate_courses',
            'course_description'=>'required',
            'course_duration'=>'required',
            'course_fee'=>'required|numeric',
            'pdf' => 'nullable|mimes:pdf|max:10000'
        ]);

         if ($request->hasFile('pdf')){
        $path = Storage::disk('public')->put('corporate_course_pdf', $request->file('pdf'));
       }

        $course = new CorporateCourses;
        $course->category_id = $request->category;
        $course->course_name = $request->course_name;
        $course->slug = Str::slug($request->course_name , '-');
        $course->course_description = $request->course_description;
        $course->course_duration = $request->course_duration;
        $course->course_fee = $request->course_fee;
        if ($request->hasFile('pdf')){
        $course->pdf = $path;
    }
        // $course->status = $request->status;
        $course->save();

        Toastr::success('Corporate Course Successfully Created', 'Success');
     return redirect(route('corporate-course.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getdata()
    {
        $course = CorporateCourses::select('corporate_courses.*','categories.category_name as category')
        ->join('categories','corporate_courses.category_id','categories.id')
        ->get();
        return Datatables::of($course)->addColumn('edit', function ($course) {
               return '<a href="'.route('corporate-course.edit',$course->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($course) {
               return '<span data-url="'.route('corporate-course.destroy',$course->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $course = CorporateCourses::findOrFail($id);
        $category = CorporateCategories::withTrashed()->where('type','!=','Exam')->pluck('id','category_name');
        return view('admin.corporate_course.edit',compact('course','category'));
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
            'course_name'=>'required|unique:corporate_courses,course_name,'.$id,
            'course_description'=>'required',
            'course_duration'=>'required',
            'course_fee'=>'required',
            'pdf' => 'nullable|mimes:pdf|max:10000'
        ]);

         if ($request->hasFile('pdf')){
        $path = Storage::disk('public')->put('corporate_course_pdf', $request->file('pdf'));
       }

        $course = CorporateCourses::findOrFail($id);
        $course->category_id = $request->category;
        $course->course_name = $request->course_name;
        $course->slug = Str::slug($request->course_name , '-');
        $course->course_description = $request->course_description;
        $course->course_duration = $request->course_duration;
        $course->course_fee = $request->course_fee;
         if ($request->hasFile('pdf')){
        $course->pdf = $path;
    }
        // $course->status = $request->status;
        $course->save();

        Toastr::success('Corporate Course Successfully Updated', 'Success');
     return redirect(route('corporate-course.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CorporateCourses::findOrFail($id)->delete();
        Toastr::error('Corporate Course Successfully Removed', 'Success');
        return redirect()->back();
    }


    public function getCourseByCategory($id)
    {
        $course = CorporateCourses::where('category_id', $id)->pluck('course_name','id');
        $courses = '';

        foreach ($course as $key => $value) {
            $courses .= '<option value="'.$key.'">'.$value.'</option>';
        };

        return $courses;
    }

    public function viewDeletedCourses()
    {
        return view('admin.corporate_course.deleted_courses');
    }

    public function getDeletedCoursesData()
    {
        $course = CorporateCourses::onlyTrashed()
        ->select('corporate_courses.*','categories.category_name as category')
        ->join('categories','corporate_courses.category_id','categories.id')
        ->get();
        return Datatables::of($course)
        ->addColumn('restore', function ($course) {
               return '<span data-url="'.route('corporate-course.restore',$course->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        CorporateCourses::withTrashed()->find($id)->restore();
        return redirect(route('corporate-course.index'));
    }

}

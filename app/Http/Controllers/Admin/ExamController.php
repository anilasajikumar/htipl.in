<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Toastr;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.exam.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Categories::where('type','!=','Online Course')->pluck('id','category_name');
        return view('admin.exam.create',compact('category'));
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
            'type'=>'required',
            'exam_name'=>'required|max:150|unique:exams',
            'exam_description'=>'required',
            'register_before_days'=>'required|numeric|min:10',
            'exam_fee'=>'required',
            'pdf' => 'nullable|mimes:pdf|max:10000'
        ]);

        if ($request->hasFile('pdf')){
        $path = Storage::disk('public')->put('exam_pdf', $request->file('pdf'));
       }


        $exam = new Exams;
        $exam->category_id = $request->category;
        $exam->type = $request->type;
        $exam->exam_name = $request->exam_name;
        $exam->slug = Str::slug($request->exam_name , '-');
        $exam->exam_description = $request->exam_description;
        $exam->register_before_days = $request->register_before_days;
        $exam->exam_fee = $request->exam_fee;
         if ($request->hasFile('pdf')){
        $exam->pdf = $path;
    }
        $exam->save();

        Toastr::success('Exam Successfully Created', 'Success');
     return redirect(route('exam.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $exam = Exams::select('exams.*','categories.category_name as category')
        ->join('categories','exams.category_id','categories.id')
        ->get();
        return Datatables::of($exam)->addColumn('edit', function ($exam) {
               return '<a href="'.route('exam.edit',$exam->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($exam) {
               return '<span data-url="'.route('exam.destroy',$exam->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $exam = Exams::findOrFail($id);
        $category = Categories::withTrashed()->where('type','!=','Online Course')->select('id','category_name','deleted_at')->get();
        return view('admin.exam.edit',compact('exam','category'));
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
            'type'=>'required',
            'exam_name'=>'required|max:150|unique:exams,exam_name,'.$id,
            'exam_description'=>'required',
            'register_before_days'=>'required|numeric|min:10',
            'exam_fee'=>'required',
            'pdf' => 'nullable|mimes:pdf|max:10000'
        ]);

         if ($request->hasFile('pdf')){
        $path = Storage::disk('public')->put('exam_pdf', $request->file('pdf'));
       }


        $exam = Exams::findOrFail($id);
        $exam->category_id = $request->category;
        $exam->type = $request->type;
        $exam->exam_name = $request->exam_name;
        $exam->slug = Str::slug($request->exam_name , '-');
        $exam->exam_description = $request->exam_description;
        $exam->register_before_days = $request->register_before_days;
        $exam->exam_fee = $request->exam_fee;
        if ($request->hasFile('pdf')){
        $exam->pdf = $path;
    }
        $exam->save();

        Toastr::success('Exam Successfully Updated', 'Success');
     return redirect(route('exam.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Exams::findOrFail($id)->delete();
        Toastr::error('Exam Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function viewDeletedExams()
    {
        return view('admin.exam.deleted_exam');
    }

    public function getDeletedExamsData()
    {
        $exam = Exams::onlyTrashed()
        ->select('exams.*','categories.category_name as category')
        ->join('categories','exams.category_id','categories.id')
        ->get();
        return Datatables::of($exam)->addColumn('restore', function ($exam) {
               return '<span data-url="'.route('exam.restore',$exam->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        Exams::withTrashed()->find($id)->restore();
        return redirect(route('exam.index'));
    }
}

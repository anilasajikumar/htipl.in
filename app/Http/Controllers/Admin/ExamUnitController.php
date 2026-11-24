<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\ExamUnits;
use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Toastr;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;

class ExamUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.exam_unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exam = Exams::select('exams.id','exams.exam_name')
        ->join('categories','exams.category_id','categories.id')
        ->where('categories.type','!=','Online Course')
        ->get();
        return view('admin.exam_unit.create',compact('exam'));
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
            'exam'=>'required',
            'unit_code'=>['required',Rule::unique('exam_units','unit_code')->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam);
            })],
            'unit_name'=>'required'
        ],['unit_code.unique' => 'This Unit Code Already In Use']);

        $exam_unit = new ExamUnits;
        $exam_unit->exam_id = $request->exam;
        $exam_unit->unit_code = $request->unit_code;
        $exam_unit->unit_name = $request->unit_name;
        $exam_unit->save();

        Toastr::success('Exam Unit Successfully Created', 'Success');
        return redirect(route('exam-unit.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $exam = ExamUnits::select('exams.exam_name','exam_units.*')
        ->join('exams','exam_units.exam_id','exams.id')
        ->join('categories','exams.category_id','categories.id')
        ->get();
        return Datatables::of($exam)->addColumn('edit', function ($exam_unit) {
               return '<a href="'.route('exam-unit.edit',$exam_unit->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($exam_unit) {
               return '<span data-url="'.route('exam-unit.destroy',$exam_unit->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $exam_unit = ExamUnits::findOrFail($id);
        $exam = Exams::select('exams.id','exams.exam_name')
        ->join('categories','exams.category_id','categories.id')
        ->where('categories.type','!=','Online Course')
        ->get();
        return view('admin.exam_unit.edit',compact('exam_unit','exam'));
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
            'exam'=>'required',
            'unit_code'=>['required',Rule::unique('exam_units','unit_code')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam);
            })],
            'unit_name'=>'required'
        ],['unit_code.unique' => 'This Unit Code Already In Use']);

        $exam_unit = ExamUnits::findOrFail($id);
        $exam_unit->exam_id = $request->exam;
        $exam_unit->unit_code = $request->unit_code;
        $exam_unit->unit_name = $request->unit_name;
        $exam_unit->save();

        Toastr::success('Exam Unit Successfully Updated', 'Success');
        return redirect(route('exam-unit.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExamUnits::findOrFail($id)->delete();
        Toastr::error('Exam Unit Successfully Removed', 'Success');
        return redirect()->back();
    }
}

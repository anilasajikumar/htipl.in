<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Categories;
use App\Models\ExamUnits;
use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Toastr;
use Yajra\Datatables\Datatables;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.alert.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.alert.create');
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
            'title'=>'required',
            'message'=>'required',
            ]);

        $alert = new Alert;
        $alert->title = $request->title;
        $alert->message = $request->message;
        $alert->save();

        Toastr::success('Alert Successfully Created', 'Success');
        return redirect(route('alert.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $alert = Alert::select('alerts.*')
        ->get();
        return Datatables::of($alert)->addColumn('edit', function ($alert) {
               return '<a href="'.route('alert.edit',$alert->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($alert) {
               return '<span data-url="'.route('alert.destroy',$alert->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $alert = Alert::findOrFail($id);
        return view('admin.alert.edit',compact('alert'));
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
            'title'=>'required',
            'message'=>'required',
            ]);

        $alert = Alert::findOrFail($id);
        $alert->title = $request->title;
        $alert->message = $request->message;
        $alert->save();

        Toastr::success('Alert Successfully Updated', 'Success');
        return redirect(route('alert.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Alert::findOrFail($id)->delete();
        Toastr::error('Alert Successfully Removed', 'Success');
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Toastr;
use Yajra\Datatables\Datatables;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.location.create');
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
        'location'=>'required|max:50|unique:locations',
      ]);

        $location = new Location;
        $location->location = $request->location;
        $location->save();
        Toastr::success('location Successfully Created', 'Success');

     return redirect(route('location.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $location = Location::select('locations.*')->get();
        return Datatables::of($location)->addColumn('edit', function ($location) {
               return '<a href="'.route('location.edit',$location->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($location) {
               return '<span data-url="'.route('location.destroy',$location->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $location = Location::findOrFail($id);
        return view('admin.location.edit',compact('location'));
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
        'location'=>'required|max:50|unique:locations,location,'.$id,
      ]);

        $location = Location::findOrFail($id);
        $location->location = $request->location;
        $location->save();
        Toastr::success('location Successfully Updated', 'Success');

     return redirect(route('location.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id)->delete();
        Toastr::error('location Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function viewDeletedLocation()
    {
        return view('admin.location.deleted');
    }

    public function getDeletedLocationData()
    {
        $location = Location::onlyTrashed()
        ->select('locations.*')
        ->get();
        return Datatables::of($location)->addColumn('restore', function ($location) {
               return '<span data-url="'.route('location.restore',$location->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        Location::withTrashed()->find($id)->restore();
        return redirect(route('location.index'));
    }
}

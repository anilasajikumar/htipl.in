<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.testimonial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
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
        'title'=>'required|max:80',
        'designation'=>'required|max:80',
        'description' =>'required',
      ]);


        $testimonial = new Testimonials;
        $testimonial->title = $request->title;
        $testimonial->designation = $request->designation;
        $testimonial->description = $request->description;
        $testimonial->save();

        Toastr::success('Testimonial Successfully Created', 'Success');
        return redirect(route('testimonial.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $testimonial = Testimonials::select('testimonials.*')->get();
        return Datatables::of($testimonial)->addColumn('edit', function ($testimonial) {
               return '<a href="'.route('testimonial.edit',$testimonial->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($testimonial) {
               return '<span data-url="'.route('testimonial.destroy',$testimonial->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $testimonial = Testimonials::findOrFail($id);
        return view('admin.testimonial.edit',compact('testimonial'));
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
        'title'=>'required|max:80',
        'designation'=>'required|max:80',
        'description' =>'required',
      ]);


        $testimonial = Testimonials::findOrFail($id);
        $testimonial->title = $request->title;
        $testimonial->designation = $request->designation;
        $testimonial->description = $request->description;
        $testimonial->save();

        Toastr::success('Testimonial Successfully Updated', 'Success');
        return redirect(route('testimonial.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonials::findOrFail($id);
        $testimonial->delete();
        
        Toastr::error('Testimonial Successfully Removed', 'Success');
        return redirect()->back();
    }
}

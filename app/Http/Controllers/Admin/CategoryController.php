<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
        'category_name'=>'required|max:100|unique:categories,category_name',
        'cover_image'=>'mimes:jpeg,jpg,png,gif|required|max:2128',
        'category_description' =>'required',
        'type' =>'required',
      ]);

        if ($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('category_images', $request->file('cover_image'));
        }


        $categories = new Categories;
        $categories->type = $request->type;
        $categories->category_name = $request->category_name;
        $categories->slug = Str::slug($request->category_name , '-');
        if ($request->hasFile('cover_image')){
            $categories->cover_image = $path;
        }
        $categories->description = $request->category_description;
        $categories->save();
        Toastr::success('Category Successfully Created', 'Success');

     return redirect(route('category.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $category = Categories::select('categories.*')->get();
        return Datatables::of($category)->addColumn('edit', function ($category) {
               return '<a href="'.route('category.edit',$category->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($category) {
               return '<span data-url="'.route('category.destroy',$category->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
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
        $category = Categories::findOrFail($id);
        return view('admin.category.edit',compact('category'));
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
        'category_name'=>'required|max:100|unique:categories,category_name,'.$id,
        'cover_image'=>'mimes:jpeg,jpg,png,gif|max:2128',
        'category_description' =>'required',
        'type' =>'required',
      ]);

        if ($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('category_images', $request->file('cover_image'));
        }


        $categories = Categories::findOrFail($id);
        $categories->type = $request->type;
        $categories->category_name = $request->category_name;
        $categories->slug = Str::slug($request->category_name , '-');
        if ($request->hasFile('cover_image')){
            $categories->cover_image = $path;
        }
        $categories->description = $request->category_description;
        $categories->save();
        Toastr::success('Category Successfully Updated', 'Success');

     return redirect(route('category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Categories::findOrFail($id);
        Storage::disk('public')->delete($categories->cover_image);
        $categories->delete();
        Toastr::error('Category Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function viewDeletedCategory()
    {
        return view('admin.category.deleted');
    }

    public function getDeletedCategoryData()
    {
        $category = Categories::onlyTrashed()
        ->select('categories.*')
        ->get();
        return Datatables::of($category)->addColumn('restore', function ($category) {
               return '<span data-url="'.route('category.restore',$category->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        Categories::withTrashed()->find($id)->restore();
        return redirect(route('category.index'));
    }
}

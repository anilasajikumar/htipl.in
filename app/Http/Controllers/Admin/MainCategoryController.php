<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategories;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class MainCategoryController extends Controller
{
    public function index()
    {
        return view('admin.main_category.index');
    }

    public function create()
    {
        return view('admin.main_category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name'        => 'required|max:100|unique:main_categories,category_name',
            'cover_image'          => 'mimes:jpeg,jpg,png,gif|required|max:2128',
            'category_description' => 'required',
            'type'                 => 'required',
        ]);

        $path = Storage::disk('public')->put('main_category_images', $request->file('cover_image'));

        MainCategories::create([
            'type'         => $request->type,
            'category_name'=> $request->category_name,
            'slug'         => Str::slug($request->category_name, '-'),
            'cover_image'  => $path,
            'description'  => $request->category_description,
            'status'       => $request->enable_status ?? 1,
        ]);

        Toastr::success('Category Successfully Created', 'Success');
        return redirect(route('m-category.index'));
    }

    public function getdata()
    {
        $category = MainCategories::select('main_categories.*')->get();
        return Datatables::of($category)
            ->addColumn('edit', fn($row) => '<a href="' . route('m-category.edit', $row->id) . '" class="btn btn-info btn-fw">Edit</a>')
            ->addColumn('action', fn($row) => '<span data-url="' . route('m-category.destroy', $row->id) . '" class="btn btn-danger btn-fw deteting-btn">Delete</span>')
            ->rawColumns(['edit', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $category = MainCategories::findOrFail($id);
        return view('admin.main_category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name'        => 'required|max:100|unique:main_categories,category_name,' . $id,
            'cover_image'          => 'mimes:jpeg,jpg,png,gif|nullable|max:2128',
            'category_description' => 'required',
            'type'                 => 'required',
        ]);

        $category = MainCategories::findOrFail($id);
        $category->type          = $request->type;
        $category->category_name = $request->category_name;
        $category->slug          = Str::slug($request->category_name, '-');
        $category->description   = $request->category_description;
        $category->status        = $request->enable_status ?? 1;

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($category->cover_image);
            $category->cover_image = Storage::disk('public')->put('main_category_images', $request->file('cover_image'));
        }

        $category->save();
        Toastr::success('Category Successfully Updated', 'Success');
        return redirect(route('m-category.index'));
    }

    public function destroy($id)
    {
        $category = MainCategories::findOrFail($id);
        Storage::disk('public')->delete($category->cover_image);
        $category->delete();
        Toastr::error('Category Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function viewDeletedCategory()
    {
        return view('admin.main_category.deleted');
    }

    public function getDeletedCategoryData()
    {
        $category = MainCategories::onlyTrashed()->select('main_categories.*')->get();
        return Datatables::of($category)
            ->addColumn('restore', fn($row) => '<span data-url="' . route('main_category.restore', $row->id) . '" class="btn btn-success btn-fw deteting-btn">Restore</span>')
            ->rawColumns(['restore'])
            ->addIndexColumn()
            ->make(true);
    }

    public function Restore($id)
    {
        MainCategories::withTrashed()->find($id)->restore();
        Toastr::success('Category Successfully Restored', 'Success');
        return redirect(route('m-category.index'));
    }
}

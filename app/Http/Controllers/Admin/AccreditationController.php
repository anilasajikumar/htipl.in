<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class AccreditationController extends Controller
{
    public function index()
    {
        return view('admin.accreditation.index');
    }

    public function create()
    {
        return view('admin.accreditation.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:2128'
        ]);

        $path = Storage::disk('public')->put('accreditation_image', $request->file('image'));

        Accreditation::create([
            'title' => $request->title,
            'image' => $path,
        ]);

        Toastr::success('Accreditation Successfully Created', 'Success');
        return redirect(route('accreditation.index'));
    }

    public function getdata()
    {
        $accreditation = Accreditation::select('accreditations.*')->get();
        return Datatables::of($accreditation)
            ->addColumn('edit', function ($row) {
                return '<a href="' . route('accreditation.edit', $row->id) . '" class="btn btn-info btn-fw">Edit</a>';
            })
            ->addColumn('action', function ($row) {
                return '<span data-url="' . route('accreditation.destroy', $row->id) . '" class="btn btn-danger btn-fw deteting-btn">Delete</span>';
            })
            ->rawColumns(['edit', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $accreditation = Accreditation::findOrFail($id);
        return view('admin.accreditation.edit', compact('accreditation'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'image' => 'mimes:jpeg,jpg,png,gif|nullable|max:2128'
        ]);

        $accreditation = Accreditation::findOrFail($id);
        $accreditation->title = $request->title;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($accreditation->image);
            $accreditation->image = Storage::disk('public')->put('accreditation_image', $request->file('image'));
        }

        $accreditation->save();
        Toastr::success('Accreditation Successfully Updated', 'Success');
        return redirect(route('accreditation.index'));
    }

    public function destroy($id)
    {
        $accreditation = Accreditation::findOrFail($id);
        Storage::disk('public')->delete($accreditation->image);
        $accreditation->delete();
        Toastr::error('Accreditation Successfully Removed', 'Success');
        return redirect()->back();
    }
}

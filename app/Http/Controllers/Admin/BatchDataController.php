<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Toastr;
use Yajra\Datatables\Datatables;

class BatchDataController extends Controller
{
    public function index()
    {
        return view('admin.batch.index');
    }

    public function create()
    {
        return view('admin.batch.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required']);

        Batch::create(['title' => $request->title]);

        Toastr::success('Batch Successfully Created', 'Success');
        return redirect(route('batch.index'));
    }

    public function getdata()
    {
        $batches = Batch::select('batches.*')->get();
        return Datatables::of($batches)
            ->addColumn('edit', fn($r) => '<a href="'.route('batch.edit', $r->id).'" class="btn btn-info btn-fw">Edit</a>')
            ->addColumn('action', fn($r) => '<span data-url="'.route('batch.destroy', $r->id).'" class="btn btn-danger btn-fw deteting-btn">Delete</span>')
            ->rawColumns(['edit', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $batch = Batch::findOrFail($id);
        return view('admin.batch.edit', compact('batch'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, ['title' => 'required']);

        Batch::findOrFail($id)->update(['title' => $request->title]);

        Toastr::success('Batch Successfully Updated', 'Success');
        return redirect(route('batch.index'));
    }

    public function destroy($id)
    {
        Batch::findOrFail($id)->delete();
        Toastr::error('Batch Successfully Removed', 'Success');
        return redirect()->back();
    }
}

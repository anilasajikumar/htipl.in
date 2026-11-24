<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainor;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Toastr;

class TrainorController extends Controller
{
    public function index()
    {
        $trainors = Trainor::with('batch')->get();
        return view('admin.trainor.index', compact('trainors'));
    }

    public function create()
    {
        $batches = Batch::all();
        return view('admin.trainor.create', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:trainors,email',
            'phone'                 => 'nullable|string|max:20',
            'batch_id'              => 'nullable|exists:batches,id',
            'password'              => 'required|string|min:6|confirmed',
            'expertise'             => 'nullable|string|max:255',
        ]);

        Trainor::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'batch_id'  => $request->batch_id,
            'expertise' => $request->expertise,
            'password'  => Hash::make($request->password),
            'status'    => 1,
        ]);

        Toastr::success('Trainor Created Successfully', 'Success');
        return redirect()->route('trainor.index');
    }

    public function show($id)
    {
        $trainor = Trainor::with('batch')->findOrFail($id);
        return view('admin.trainor.show', compact('trainor'));
    }

    public function edit($id)
    {
        $trainor = Trainor::findOrFail($id);
        $batches = Batch::all();
        return view('admin.trainor.edit', compact('trainor', 'batches'));
    }

    public function update(Request $request, $id)
    {
        $trainor = Trainor::findOrFail($id);
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:trainors,email,' . $trainor->id,
            'phone'     => 'nullable|string|max:20',
            'batch_id'  => 'nullable|exists:batches,id',
            'expertise' => 'nullable|string|max:255',
        ]);

        $trainor->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'batch_id'  => $request->batch_id,
            'expertise' => $request->expertise,
        ]);

        Toastr::success('Trainor Updated Successfully', 'Updated');
        return redirect()->route('trainor.index');
    }

    public function destroy($id)
    {
        Trainor::findOrFail($id)->delete();
        Toastr::success('Trainor Deleted Successfully', 'Deleted');
        return redirect()->route('trainor.index');
    }

    public function toggleStatus($id)
    {
        $trainor = Trainor::findOrFail($id);
        $trainor->status = $trainor->status ? 0 : 1;
        $trainor->save();
        Toastr::success($trainor->status ? 'Trainor Activated' : 'Trainor Deactivated', 'Success');
        return redirect()->route('trainor.index');
    }

    public function editPassword($id)
    {
        $trainor = Trainor::findOrFail($id);
        return view('admin.trainor.change_password', compact('trainor'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate(['password' => 'required|string|min:6|confirmed']);
        Trainor::findOrFail($id)->update(['password' => Hash::make($request->password)]);
        Toastr::success('Password Updated Successfully', 'Success');
        return redirect()->route('trainor.index');
    }
}

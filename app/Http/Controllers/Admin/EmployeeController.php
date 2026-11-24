<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Toastr;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:191',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'first_name' => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'employee',
        ]);

        Toastr::success('Employee created successfully', 'Success');
        return redirect()->route('employees.index');
    }

    public function resetPassword($id)
    {
        $employee = User::findOrFail($id);
        $newPassword = 'Emp@12345';
        $employee->password = Hash::make($newPassword);
        $employee->save();

        Toastr::success('Password reset. New Password: ' . $newPassword, 'Success');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate(['user_id' => 'required', 'password' => 'required|min:6']);
        User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
        Toastr::success('Password updated successfully', 'Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        User::where('role', 'employee')->findOrFail($id)->delete();
        Toastr::error('Employee deleted successfully', 'Deleted');
        return redirect()->back();
    }
}

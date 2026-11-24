<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use Toastr;

class FooterController extends Controller
{
    public function index()
    {
        $records = Footer::latest()->paginate(10);
        return view('admin.footer.index', compact('records'));
    }

    public function create()
    {
        return view('admin.footer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:7,15',
        ]);

        Footer::create($request->only('name', 'phone'));

        Toastr::success('Footer record created successfully.', 'Success');
        return redirect()->route('footer.index');
    }

    public function edit($id)
    {
        $record = Footer::findOrFail($id);
        return view('admin.footer.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:7,15',
        ]);

        Footer::findOrFail($id)->update($request->only('name', 'phone'));

        Toastr::success('Footer record updated successfully.', 'Success');
        return redirect()->route('footer.index');
    }

    public function destroy($id)
    {
        Footer::findOrFail($id)->delete();

        Toastr::error('Footer record deleted.', 'Deleted');
        return redirect()->route('footer.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Toastr;
use Yajra\Datatables\Datatables;

class CountryController extends Controller
{
    public function index()
    {
        return view('admin.country.index');
    }

    public function create()
    {
        return view('admin.country.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'country' => 'required|max:50|unique:countries',
        ]);

        Country::create(['country' => $request->country]);
        Toastr::success('Country Successfully Created', 'Success');
        return redirect(route('country.index'));
    }

    public function getdata()
    {
        $country = Country::select('countries.*')->get();
        return Datatables::of($country)
            ->addColumn('edit', fn($row) => '<a href="' . route('country.edit', $row->id) . '" class="btn btn-info btn-fw">Edit</a>')
            ->addColumn('action', fn($row) => '<span data-url="' . route('country.destroy', $row->id) . '" class="btn btn-danger btn-fw deteting-btn">Delete</span>')
            ->rawColumns(['edit', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('admin.country.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'country' => 'required|max:50|unique:countries,country,' . $id,
        ]);

        Country::findOrFail($id)->update(['country' => $request->country]);
        Toastr::success('Country Successfully Updated', 'Success');
        return redirect(route('country.index'));
    }

    public function destroy($id)
    {
        Country::findOrFail($id)->delete();
        Toastr::error('Country Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function viewDeletedCountry()
    {
        return view('admin.country.deleted');
    }

    public function getDeletedCountryData()
    {
        $country = Country::onlyTrashed()->select('countries.*')->get();
        return Datatables::of($country)
            ->addColumn('restore', fn($row) => '<span data-url="' . route('country.restore', $row->id) . '" class="btn btn-success btn-fw deteting-btn">Restore</span>')
            ->rawColumns(['restore'])
            ->addIndexColumn()
            ->make(true);
    }

    public function Restore($id)
    {
        Country::withTrashed()->find($id)->restore();
        Toastr::success('Country Successfully Restored', 'Success');
        return redirect(route('country.index'));
    }
}

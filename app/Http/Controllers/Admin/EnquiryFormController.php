<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnquiryForm;
use App\Models\Centers;
use App\Models\OnlineCourse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Toastr;
use Yajra\Datatables\Datatables;

class EnquiryFormController extends Controller
{
    public function index()
    {
        $years = EnquiryForm::select(DB::raw('YEAR(enquiry_date) as year'))
            ->distinct()->orderBy('year', 'desc')->pluck('year')->toArray();
        $month = 1;
        $year  = date('Y');
        return view('admin.enquiryForm.index', compact('month', 'year', 'years'));
    }

    public function postdata(Request $request)
    {
        $years = EnquiryForm::select(DB::raw('YEAR(enquiry_date) as year'))
            ->distinct()->orderBy('year', 'desc')->pluck('year')->toArray();
        $month = $request->month;
        $year  = $request->year;
        return view('admin.enquiryForm.index', compact('month', 'year', 'years'));
    }

    public function getdata(Request $request)
    {
        $month = $request->get('month');
        $year  = $request->get('year');

        $enquiries = EnquiryForm::join('centers', 'centers.id', '=', 'enquiry_forms.center')
            ->select('enquiry_forms.*', 'centers.study_center_name', 'centers.id as center_id')
            ->whereRaw('MONTH(enquiry_forms.enquiry_date) = ?', [$month])
            ->whereRaw('YEAR(enquiry_forms.enquiry_date) = ?', [$year])
            ->get();

        return Datatables::of($enquiries)
            ->addColumn('course_name', function ($row) {
                $ids = json_decode($row->course, true) ?: [];
                return OnlineCourse::whereIn('id', $ids)->pluck('course_name')->implode(', ');
            })
            ->addColumn('center_name', fn($r) => $r->study_center_name)
            ->addColumn('enquiryDate', fn($r) => date('d-m-Y', strtotime($r->enquiry_date)))
            ->addColumn('dob', fn($r) => $r->dob ? date('d-m-Y', strtotime($r->dob)) : '')
            ->addColumn('edit', fn($r) => '<a href="'.route('enquiry-form.edit', $r->id).'" class="btn btn-info btn-fw btn-sm">Edit</a>')
            ->addColumn('action', fn($r) => '<span data-url="'.route('enquiry-form.destroy', $r->id).'" class="btn btn-danger btn-fw btn-sm deteting-btn">Delete</span>')
            ->rawColumns(['edit', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $centers = Centers::where('status', 1)->pluck('id', 'study_center_name');
        $course  = OnlineCourse::where('status', 1)->pluck('id', 'course_name');
        return view('admin.enquiryForm.create', compact('centers', 'course'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'           => 'required',
            'email'          => 'required|unique:enquiry_forms',
            'contact_number' => 'required',
            'center'         => 'required',
            'course'         => 'required|array|min:1',
            'message'        => 'required',
            'dob'            => 'required',
            'enquiry_date'   => 'required',
        ]);

        $form = new EnquiryForm;
        $form->fill($request->only(['name', 'email', 'contact_number', 'center', 'message', 'dob', 'address', 'gender', 'enquiry_date']));
        $form->course = json_encode($request->course);
        $form->save();

        Toastr::success('Enquiry Form Successfully Created', 'Success');
        return redirect(route('enquiry-form.index'));
    }

    public function edit($id)
    {
        $centers     = Centers::where('status', 1)->pluck('id', 'study_center_name');
        $course      = OnlineCourse::where('status', 1)->pluck('id', 'course_name');
        $enquiry_form = EnquiryForm::findOrFail($id);
        return view('admin.enquiryForm.edit', compact('centers', 'course', 'enquiry_form'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'           => 'required',
            'email'          => ['required', Rule::unique('enquiry_forms')->ignore($id)],
            'contact_number' => 'required',
            'center'         => 'required',
            'course'         => 'required|array|min:1',
            'message'        => 'required',
            'dob'            => 'required',
            'enquiry_date'   => 'required',
        ]);

        $form = EnquiryForm::findOrFail($id);
        $form->fill($request->only(['name', 'email', 'contact_number', 'center', 'message', 'dob', 'address', 'gender', 'enquiry_date']));
        $form->course = json_encode($request->course);
        $form->save();

        Toastr::success('Enquiry Form Successfully Updated', 'Success');
        return redirect(route('enquiry-form.index'));
    }

    public function destroy($id)
    {
        EnquiryForm::findOrFail($id)->delete();
        Toastr::error('Enquiry Form Successfully Removed', 'Success');
        return redirect()->back();
    }
}

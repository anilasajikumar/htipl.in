<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterDocumentDatas;
use App\Models\OnlineCourse;
use Illuminate\Http\Request;
use Toastr;
use Yajra\Datatables\Datatables;

class MasterDocumentDataController extends Controller
{
    public function index()
    {
        return view('admin.masterDocumentData.index');
    }

    public function create()
    {
        $course = OnlineCourse::pluck('id', 'course_name');
        return view('admin.masterDocumentData.create', compact('course'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'    => 'required',
            'category' => 'required',
            'default_file' => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $doc = new MasterDocumentDatas;

        if ($request->hasFile('default_file')) {
            $file = $request->file('default_file');
            $name = $file->getClientOriginalName();
            $file->move(public_path('masterDocuments'), $name);
            $doc->default_file = $name;
        }

        $doc->title    = $request->title;
        $doc->text     = $request->has('text') ? 1 : 0;
        $doc->file     = $request->has('file') ? 1 : 0;
        $doc->student_upload = $request->has('student_upload') ? 1 : 0;
        $doc->download = $request->has('download') ? 1 : 0;
        $doc->student_download_default_file = $request->has('student_download_default_file') ? 1 : 0;
        $doc->category  = $request->category;
        $doc->course_id = $request->course_id;
        $doc->save();

        Toastr::success('Master Document Data Successfully Created', 'Success');
        return redirect(route('masterdocumentdata.index'));
    }

    public function getdata()
    {
        $docs = MasterDocumentDatas::leftJoin('online_courses', 'online_courses.id', 'master_document_datas.course_id')
            ->select('master_document_datas.*', 'online_courses.course_name')
            ->get();

        $catMap = [
            'my_document'      => 'My Document',
            'my_download'      => 'My Download',
            'exam_assignments' => 'Exam & Assignments',
            'feedback'         => 'Feedback',
        ];

        return Datatables::of($docs)
            ->addColumn('edit', fn($r) => '<a href="'.route('masterdocumentdata.edit', $r->id).'" class="btn btn-info btn-fw btn-sm">Edit</a>')
            ->addColumn('action', fn($r) => '<span data-url="'.route('masterdocumentdata.destroy', $r->id).'" class="btn btn-danger btn-fw btn-sm deteting-btn">Delete</span>')
            ->addColumn('text', fn($r) => $r->text ? 'Yes' : 'No')
            ->addColumn('file', fn($r) => $r->file ? 'Yes' : 'No')
            ->addColumn('student_upload', fn($r) => $r->student_upload ? 'Yes' : 'No')
            ->addColumn('download', fn($r) => $r->download ? 'Yes' : 'No')
            ->addColumn('default_file_path', fn($r) => $r->default_file
                ? '<a href="'.asset('masterDocuments/'.$r->default_file).'" class="btn btn-sm btn-info" download>Download</a>'
                : 'No file')
            ->addColumn('student_download_default_file', fn($r) => $r->student_download_default_file ? 'Yes' : 'No')
            ->addColumn('category_name', fn($r) => $catMap[$r->category] ?? $r->category)
            ->rawColumns(['edit', 'action', 'default_file_path'])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $master_document_data = MasterDocumentDatas::findOrFail($id);
        $course = OnlineCourse::pluck('id', 'course_name');
        return view('admin.masterDocumentData.edit', compact('master_document_data', 'course'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'    => 'required',
            'category' => 'required',
            'default_file' => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $doc = MasterDocumentDatas::findOrFail($id);

        if ($request->hasFile('default_file')) {
            $file = $request->file('default_file');
            $name = $file->getClientOriginalName();
            $file->move(public_path('masterDocuments'), $name);
            $doc->default_file = $name;
        }

        $doc->title    = $request->title;
        $doc->text     = $request->has('text') ? 1 : 0;
        $doc->file     = $request->has('file') ? 1 : 0;
        $doc->student_upload = $request->has('student_upload') ? 1 : 0;
        $doc->download = $request->has('download') ? 1 : 0;
        $doc->student_download_default_file = $request->has('student_download_default_file') ? 1 : 0;
        $doc->category  = $request->category;
        $doc->course_id = $request->course_id;
        $doc->save();

        Toastr::success('Master Document Data Successfully Updated', 'Success');
        return redirect(route('masterdocumentdata.index'));
    }

    public function destroy($id)
    {
        MasterDocumentDatas::findOrFail($id)->delete();
        Toastr::error('Master Document Data Successfully Removed', 'Success');
        return redirect()->back();
    }
}

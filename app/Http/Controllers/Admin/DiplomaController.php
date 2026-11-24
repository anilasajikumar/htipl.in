<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineCourse;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Toastr;
use DB;

class DiplomaController extends Controller
{
    public function index()
    {
        $students = DB::table('student_courses')
            ->join('online_courses', 'student_courses.center_online_courses_id', '=', 'online_courses.id')
            ->whereNull('student_courses.deleted_at')
            ->where('student_courses.course_type', 'Diploma')
            ->select(
                'student_courses.id',
                'student_courses.name as student_name',
                'student_courses.email',
                'student_courses.mobile',
                'student_courses.register_number',
                'student_courses.father_name',
                'student_courses.passout_year_month',
                'online_courses.course_name'
            )
            ->orderBy('student_courses.id', 'desc')
            ->get();

        return view('admin.diploma.index', compact('students'));
    }

    public function create()
    {
        $courses = OnlineCourse::all();
        return view('admin.diploma.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'      => 'required|exists:online_courses,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email',
            'mobile'         => 'required|numeric',
            'father_name'    => 'required|string|max:255',
            'dob'            => 'required|date',
            'gender'         => 'required',
            'address'        => 'required',
            'passout_year'   => 'required|digits:4',
            'passout_month'  => 'required|digits:2',
            'id_proof'       => 'nullable|mimes:pdf|max:5120',
            'image'          => 'nullable|mimes:jpeg,jpg,png,gif|max:2128',
        ]);

        // Generate register number
        $latest = StudentCourse::withTrashed()->orderBy('id', 'desc')->first();
        $registerNumber = $latest ? ++$latest->register_number : 'HTIO1098';

        $idProofPath = $request->hasFile('id_proof')
            ? $request->file('id_proof')->store('id_proofs', 'public')
            : null;

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        $student = new StudentCourse();
        $student->center_online_courses_id = $request->course_id;
        $student->name                     = $request->name;
        $student->email                    = $request->email;
        $student->mobile                   = $request->mobile;
        $student->father_name              = $request->father_name;
        $student->dob                      = $request->dob;
        $student->gender                   = $request->gender;
        $student->address                  = $request->address;
        $student->passout_year_month       = $request->passout_year . '-' . $request->passout_month;
        $student->register_number          = $registerNumber;
        $student->id_proof                 = $idProofPath;
        $student->image                    = $imagePath;
        $student->course_type              = 'Diploma';
        $student->status                   = '1';
        $student->save();

        Toastr::success('Diploma student registered successfully.', 'Success');
        return redirect()->route('diploma.index');
    }

    public function destroy($id)
    {
        $student = StudentCourse::findOrFail($id);
        $student->delete();

        Toastr::error('Student removed.', 'Deleted');
        return redirect()->route('diploma.index');
    }
}

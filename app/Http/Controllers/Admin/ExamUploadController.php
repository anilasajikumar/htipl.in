<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Examupload;
use App\Models\ExamSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamUploadController extends Controller
{
    public function index()
    {
        $exams = Examupload::latest()->get();
        return view('admin.examupload.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.examupload.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file'  => 'nullable|mimes:pdf,doc,docx|max:4096',
        ]);
    
        $filePath = null;
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
    
            // IMPORTANT CHANGE HERE
            $file->move(public_path('exam_files'), $fileName);
    
            // Save relative path
            $filePath = 'exam_files/'.$fileName;
        }
    
        Examupload::create([
            'title'       => $request->title,
            'description' => $request->description,
            'file_path'   => $filePath,
        ]);
    
        return redirect()->route('examupload.index')
                         ->with('success','Exam created');
    }


  
    
   public function report()
{
    // get all submissions with student data
    $submissions = DB::table('exam_submissions')
        ->join('student_courses', 'exam_submissions.student_id', '=', 'student_courses.id')
        ->join('examupload', 'exam_submissions.exam_id', '=', 'examupload.id')
        ->select(
            'exam_submissions.id as submission_id',
            'examupload.title as exam_title',
            'student_courses.name as student_name',
            'exam_submissions.file_path',
            'exam_submissions.submitted_at'
        )
        ->orderBy('exam_submissions.submitted_at', 'desc')
        ->get();

    return view('admin.examupload.report', compact('submissions'));
}

}

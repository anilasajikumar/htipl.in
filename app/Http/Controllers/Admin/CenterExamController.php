<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnswerFile;
use App\Models\CenterExams;
use App\Models\Centers;
use App\Models\Certificates;
use App\Models\ExamCenters;
use App\Models\ExamCertificates;
use App\Models\ExamUnits;
use App\Models\Exams;
use App\Models\StudentExams;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PDF;
use Toastr;
use Yajra\Datatables\Datatables;

class CenterExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.center.exam.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $exam = Exams::pluck('id','exam_name');
        $center = Centers::pluck('id','study_center_name');
        return view('admin.center.exam.create',compact('exam','center'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'exam'=>['required',Rule::unique('center_exams','exam_id')->where(function ($query) use ($request) {
    return $query->where('center_id', $request->center);
})],
            'center'=>'required',
        ],['exam.unique' => 'This Exam Already Assigned To Center']);

        $center_exam = new CenterExams;
        $center_exam->exam_id = $request->exam;
        $center_exam->center_id = $request->center;
        $center_exam->save();

        Toastr::success('Exam Successfully Assigned', 'Success');
     return redirect(route('center-exam.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $center_exam = CenterExams::select('center_exams.*','centers.study_center_name as center','exams.exam_name as exam')
        ->join('exams','center_exams.exam_id','exams.id')
        ->join('centers','center_exams.center_id','centers.id')
        ->get();
        return Datatables::of($center_exam)->addColumn('edit', function ($center_exam) {
               return '<a href="'.route('center-exam.edit',$center_exam->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($center_exam) {
               return '<span data-url="'.route('center-exam.destroy',$center_exam->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
           })->rawColumns(['edit','action'])
        ->addIndexColumn()
        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $center_exam = CenterExams::findOrFail($id);
        $exam = Exams::pluck('id','exam_name');
        $center = Centers::pluck('id','study_center_name');
        return view('admin.center.exam.edit',compact('center_exam','exam','center'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'exam'=>['required',Rule::unique('center_exams','exam_id')->ignore($id)->where(function ($query) use ($request) {
    return $query->where('center_id', $request->center);
})],
            'center'=>['required',Rule::unique('center_exams','center_id')->ignore($id)->where(function ($query) use ($request) {
    return $query->where('exam_id', $request->exam);
})],
        ],['exam.unique' => 'This Exam Already Assigned To Center',
        'center.unique' => 'This Exam Already Assigned To Center']);

        $center_exam = CenterExams::findOrFail($id);
        $center_exam->exam_id = $request->exam;
        $center_exam->center_id = $request->center;
        $center_exam->save();

        Toastr::success('Successfully Updated', 'Success');
     return redirect(route('center-exam.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CenterExams::findOrFail($id)->delete();
        Toastr::error('Successfully Removed', 'Success');
        return redirect()->back();
    }


    public function pendingExam()
    {
        return view('admin.center.exam.pending_exams');
    }

    public function pendingExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email','centers.study_center_name')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where('exam_centers.status','=','0')
        ->get();

        return Datatables::of($exams)->addColumn('approve', function ($exams) {
               return '<a href="'.route('center-exam.approve',$exams->id).'">Approve</a>';
           })
        ->rawColumns(['approve'])
        ->addIndexColumn()
        ->make(true);
    }


    public function activeExam()
    {
        return view('admin.center.exam.active_exams');
    }


    public function activeExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email','centers.study_center_name')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->whereDate('exam_centers.closing_date','>=',Carbon::now())
        ->where([['exam_centers.status','=','1']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('center_exam.students',$exams->id).'">View More</a>';
           })
        ->rawColumns(['view'])
        ->addIndexColumn()
        ->make(true);
    }

     public function completedExam()
    {
        return view('admin.center.exam.completed_exams');
    }


    public function completedExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email','centers.study_center_name')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.closing_date','<',Carbon::now()],['exam_centers.result_published','=','No']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('completed_exam.students',$exams->id).'">View More</a>';
           })
         ->addColumn('published', function ($students){

        $count = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('student_exams.exam_center_id','=',$students->id)
        ->count();

        $result_count = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where([['student_exams.exam_center_id','=',$students->id],['student_exams.result','!=','null']])
        ->count();

        if($count == $result_count){

            return '<a href="'.route('completed.exams.published',$students->id).'" class="btn btn-info btn-fw">Mark Published</a>';
          }
          else
          {
            return '<a class="btn btn-info btn-fw">Mark Published</a>';
          }
        })
        ->rawColumns(['view','published'])
        ->addIndexColumn()
        ->make(true);
    }

    public function liveExam()
    {
        return view('admin.center.exam.live_exams');
    }


    public function liveExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email','centers.study_center_name')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.closing_date','<=',Carbon::now()],['exam_centers.payment_status','=','1'],['exam_centers.status','=','3']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('admin.hall_ticket.students',$exams->id).'">View More</a>';
           })
        ->rawColumns(['view'])
        ->addIndexColumn()
        ->make(true);
    }

    public function closedExam()
    {
        return view('admin.center.exam.closed_exams');
    }


    public function closedExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email','centers.study_center_name')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->whereDate('exam_centers.closing_date','<',Carbon::now())
        ->where([['exam_centers.payment_status','=','0']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('invoice', function ($exams) {
               return '<a href="'.route('center_exam_invoice',$exams->id).'" class="btn btn-info btn-fw">invoice</a>';
           })
        ->addColumn('live', function ($exams) {
               return '<a href="'.route('center_exam_payment',$exams->id).'">Payment Received</a>';
           })
        ->rawColumns(['invoice','live'])
        ->addIndexColumn()
        ->make(true);
    }



    public function centerExamStudents($id)
    {
        $exam_center_id = $id;
        return view('admin.center.exam.student_exams',compact('exam_center_id'));
    }

    public function centerExamStudentsData($id)
    {
        $students = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('student_exams.exam_center_id','=',$id)
        ->get();

        return Datatables::of($students)->make(true);
    }


    public function completedExamStudents($id)
    {
        $exam_center_id = $id;
        return view('admin.center.exam.completed_exam_students',compact('exam_center_id'));
    }


    public function completedExamStudentsData($id)
    {
         $students = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('student_exams.exam_center_id','=',$id)
        ->get();

        return Datatables::of($students)->addColumn('upload', function ($students) {
            
               return '<a href="'.route('result.upload',$students->id).'" class="btn btn-info btn-fw">Upload Result</a>';
         
           })->addColumn('view_answers', function ($students) {
            if($students->type != 'ICRQ'){
               return '<a href="'.route('view_answers',$students->id).'" class="btn btn-info btn-fw">View Answers</a>';
           }
           return '';
           })
        ->rawColumns(['upload','view_answers'])
        ->make(true);
    }


    public function ResultPublishedStudents($id)
    {
        $exam_center_id = $id;
        return view('admin.center.exam.result_published_students',compact('exam_center_id'));
    }


    public function ResultPublishedStudentsData($id)
    {
       $students = StudentExams::select('student_exams.*','exams.type')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('student_exams.exam_center_id','=',$id)
        ->get();

         return Datatables::of($students)->addColumn('download_results', function ($students) {
               return '<a href="'.route('download.result_file',$students->id).'" class="btn btn-info btn-fw">Download Result</a>';
           })->addColumn('download_certificate', function ($students) {
               return '<a href="'.route('download.certificate',$students->id).'" class="btn btn-primary btn-fw">Download Certificate</a>';
           })
        ->rawColumns(['download_results','download_certificate'])
        ->make(true);
    }

    public function approvePendingExam($id)
    {
        $center_exam = ExamCenters::findOrFail($id);
        $center_exam->status = '1';
        $center_exam->save();
        Toastr::success('Successfully Approved', 'Success');
        return redirect()->back();
    }

    public function centerExamPayment($id)
    {
        $center_exam = ExamCenters::findOrFail($id);
        $center_exam->payment_status = '1';
        $center_exam->status = '3';
        $center_exam->save();
        Toastr::success('Successfully Approved', 'Success');
        return redirect()->back();
    }

    public function centerExamInvoice($id)
    {
       $data = ExamCenters::select('exams.exam_name','exams.exam_fee','exam_centers.*','centers.*')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.id','=',$id]])
        ->withCount('studentExams')
        ->first();

        if($data == null){
            return abort(404);
        }

        $pdf = PDF::loadView('admin.center.exam.invoice',compact('data'));
        return $pdf->download('invoice.pdf');
    }

    public function uploadResultFile($id)
    {
         $student_id = $id;
         $files = StudentExams::findOrFail($student_id);
         return view('admin.center.exam.upload_result',compact('student_id','files'));
    }

    public function SaveResultFile(Request $request, $id)
    {
        $this->validate($request, [
                'file' => 'required',
                'file.*' => 'mimes:pdf'
        ],['file.*' => 'The file must be a file of type: pdf.']);
        
        
                $name = $request->file('file')->getClientOriginalName();
                $request->file('file')->move(storage_path().'/app/public/result_files/', $name);  
  
                $result_file = StudentExams::findOrFail($id);
                $result_file->file = 'result_files/'.$name;
                $result_file->result = $request->result;
                $result_file->save();

      $check_cert = ExamCertificates::all();
      if($check_cert->isEmpty()){
        $certificate_id = "HTI0001";
      }
      else
      {
        $latest = ExamCertificates::latest()->first();
        $certificate_id = ++$latest->certificate_id;
      }

    $center_and_exam = StudentExams::select('centers.study_center_name','exams.exam_name','student_exams.exam_center_id')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('student_exams.id','=',$id)
        ->first();

    $certificate = new ExamCertificates;
    $certificate->student_exam_id = $result_file->id;
    $certificate->certificate_id = $certificate_id;
    $certificate->student_name = $result_file->name;
    $certificate->center_name = $center_and_exam->study_center_name;
    $certificate->exam_name = $center_and_exam->exam_name;
    $certificate->result = $result_file->result;
    $certificate->date_of_awarded =  Carbon::now();
    $certificate->save();

      Toastr::success('Certificate Successfully Generated', 'Success');
      return redirect(route('completed_exam.students',$center_and_exam->exam_center_id));
        
    }

    public function MakeExamAsPublished($id)
    {
        $exam_center = ExamCenters::findOrFail($id);
        $exam_center->result_published = "Yes";
        $exam_center->save();
        Toastr::success('Successfully Published', 'Success');
        return redirect(route('admin.completed_exam'));
    }


     public function ResultPublishedExam()
    {
        return view('admin.center.exam.result_published_exams');
    }


    public function ResultPublishedExamData()
    {
        $exams = ExamCenters::select('exams.exam_name as exam','exam_centers.*','centers.study_center_email','centers.study_center_name')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where([['exam_centers.date','<',Carbon::now()],['exam_centers.result_published','=','Yes']])
        ->withCount('studentExams')
        ->get();

        return Datatables::of($exams)->addColumn('view', function ($exams) {
               return '<a href="'.route('result_published_students',$exams->id).'">View More</a>';
           })
        ->rawColumns(['view'])
        ->addIndexColumn()
        ->make(true);
    }

    public function ViewAnswers($id)
    {
         $files = AnswerFile::where('student_id','=',$id)->get();
        return view('admin.center.exam.view_answers',compact('files'));
    }

    public function downloadAnswerFile($id)
    {
        $files = AnswerFile::findOrFail($id);
        return Storage::disk('public')->download($files->file,'answer.pdf');
    }

    public function downloadResultFile($id)
    {
        $files = StudentExams::findOrFail($id);
        return Storage::disk('public')->download($files->file,'result.pdf');
    }

    public function downloadCertificate($id)
    {
      $certificate = ExamCertificates::where('student_exam_id','=',$id)->first();

      if($certificate->result == 'fail'){
            Toastr::error('Failed In Exam', 'Error');
            return redirect()->back();
        }

       $customPaper = array(0,0,720,1440);
       $pdf = PDF::loadView('admin.center.exam.certificate',compact('certificate'))->setPaper($customPaper,'portrait');
       
        return $pdf->download('certificate.pdf');
    }

    public function hallticketList($id)
    {
        $exam_center_id = $id;
        return view('admin.center.exam.hallticket_students',compact('exam_center_id'));
    }


    public function hallticketListData($id)
    {
        $students = StudentExams::select('student_exams.*')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->where('student_exams.exam_center_id','=',$id)
        ->get();

        return Datatables::of($students)->addColumn('hall_ticket', function ($students) {
               return '<a href="'.route('admin.hall_tickets.download',$students->id).'" class="btn btn-info btn-fw">Download</a>';
           })
        ->rawColumns(['hall_ticket'])
        ->addIndexColumn()
        ->make(true);
    }


    public function downloadHallTickets($id)
    {
      $data = StudentExams::select('student_exams.register_number','student_exams.name','student_exams.email','student_exams.mobile','student_exams.address','exams.exam_name','exam_centers.center_address','centers.study_center_name','centers.study_center_address','exam_centers.date','exams.id as examination_id','centers.study_center_mobile','centers.study_center_email')
        ->join('exam_centers','student_exams.exam_center_id','exam_centers.id')
        ->join('centers','exam_centers.center_id','centers.id')
        ->join('exams','exam_centers.exam_id','exams.id')
        ->where('student_exams.id','=',$id)
        ->first();

      $exam_units = ExamUnits::select('exam_units.*')
      ->where('exam_id','=',$data->examination_id)
      ->get();

        if($data == null){
            return abort(404);
        }
      $pdf = PDF::loadView('admin.center.exam.hall_ticket',compact('data','exam_units'));
        return $pdf->download('hall_ticket.pdf');
    }


    public function centerExamTrash()
    {
        return view('admin.center.exam.trash');
    }


    public function centerExamTrashData()
    {
        $center_exam = CenterExams::select('center_exams.*','centers.study_center_name as center','exams.exam_name as exam')
        ->join('exams','center_exams.exam_id','exams.id')
        ->join('centers','center_exams.center_id','centers.id')
        ->onlyTrashed()
        ->get();

        return Datatables::of($center_exam)->addColumn('restore', function ($center_exam) {
               return '<span data-url="'.route('center-exam.restore',$center_exam->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        CenterExams::withTrashed()->find($id)->restore();
        return redirect(route('center-exam.index'));
    }

}

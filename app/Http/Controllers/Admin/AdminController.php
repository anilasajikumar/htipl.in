<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCalendar;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentEnquiry;
use Yajra\DataTables\DataTables;
use App\Models\Centers;
use Toastr;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }


    public function changePasswordForm()
    {
        return view('admin.settings.change_password');
    }


    public function changePassword(Request $request)
    {
        $this->validate($request, [
        'password' => 'required |confirmed| min:6 | max:12',
     ]);
    
        $admin = User::find(Auth::user()->id);
        $admin->password = Hash::make($request['password']);
        $admin->save();

        Toastr::success('Password Successfully Changed', 'Success');
        return Redirect(route('home'));
    }

    public function courseCalendar()
    {   
        $calendar = CourseCalendar::first();
        return view('admin.course_calendar',compact('calendar'));
    }

    public function UpdateCourseCalendar(Request $request, $id)
    {
        $this->validate($request, [
                'pdf' => 'required|mimes:pdf'
        ],['pdf' => 'The file must be a file of type: pdf.']);
        
        
        $name = $request->file('pdf')->getClientOriginalName();
        $request->file('pdf')->move(storage_path().'/app/public/course_calendar/', $name);

        $file = CourseCalendar::findOrFail($id);
        Storage::disk('public')->delete($file->pdf);
  
        $file = CourseCalendar::findOrFail($id);
        $file->pdf = 'course_calendar/'.$name;
        $file->save();

        Toastr::success('Successfully Created', 'Success');
        return redirect(route('home'));
    }
    
     public function enquiryreport(Request $request)
    {
        $year   = $request->year ?? date('Y');
        $month  = $request->month ?? date('m');
        $search = $request->search;

        $years = StudentEnquiry::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year','desc')
            ->pluck('year');

        $query = StudentEnquiry::with(['center','course'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%")
                  ->orWhere('contact_number','like',"%$search%");
            });
        }

        $enquiries = $query->orderBy('created_at','desc')->paginate(10);

       

        return view('admin.enquiry.index', compact('enquiries','years','year','month','search'));
    }

     public function export(Request $request)
    {
        $year  = $request->year;
        $month = $request->month;

        $enquiries = StudentEnquiry::with(['center','course'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $filename = "enquiry_report_{$month}_{$year}.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($enquiries) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name','Email','Contact','Course',
                'Center','Message','DOB','Enquiry Date'
            ]);

            foreach ($enquiries as $row) {
                fputcsv($file, [
                    $row->name,
                    $row->email,
                    $row->contact_number,
                    $row->course->course_name ?? '',
                    $row->center->study_center_name ?? '',
                    $row->message,
                    $row->dob,
                    $row->created_at->format('d-m-Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        StudentEnquiry::findOrFail($id)->delete();
        return back()->with('success','Enquiry deleted');
    }
}

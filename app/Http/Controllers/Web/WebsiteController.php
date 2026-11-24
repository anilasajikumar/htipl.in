<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\CenterRequestSendMail;
use App\Mail\StudentEnquiryToCenter;
use App\Models\Categories;
use App\Models\CenterOnlineCourse;
use App\Models\Centers;
use App\Models\Clients;
use App\Models\CorporateCategories;
use App\Models\CorporateCourses;
use App\Models\CourseCalendar;
use App\Models\Exams;
use App\Models\Location;
use App\Models\NewsAndEvents;
use App\Models\OnlineCourse;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificates;
use App\Models\ExamCertificates;
use App\Models\StudentCourses;
use App\Models\StudentExams;
use Carbon\Carbon;
use Mail;
use App\Models\Placement;
use App\Mail\PlacementApplyMail;
use App\Models\PlacementApplication;
use App\Models\PlacementApplicationConfirmationMail;
use App\Models\StudentEnquiry;
use App\Models\VideoTestimonial;
use App\Models\HeroSection;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $news_events = NewsAndEvents::all()->take(3);
        
        $corporate_categories = CorporateCategories::select('category_name','slug','cover_image')
        ->where('status','=','1')
         ->take(8)
        ->get();
        
        $clients = Clients::select('name','slug','logo')
        ->get();
        $testimonials = Testimonials::where('status','1')->get();
        $categories = Categories::select('category_name','slug','cover_image')
        ->where('status','=','1')
        ->get()
        ->take(8);

        $course_calender = CourseCalendar::select('course_calendars.*')
        ->orderBy('course_calendars.created_at','desc')
        ->get()
        ->take(2);
        
        $placements = Placement::select('placements.*')
        ->orderBy('placements.created_at', 'desc')
        ->get()
        ->take(2);

        $hero = HeroSection::where('status', 1)->latest()->first();
        
        return view('welcome',compact('news_events','testimonials','categories','corporate_categories','course_calender','clients','placements','hero'));
    }

    public function about()
    {
        $testimonials = Testimonials::where('status','1')->get();
        return view('website.about',compact('testimonials'));
    }

    public function privacyPolicy()
    {
        return view('website.privacy');
    }

    public function whereToStudy()
    {
        return view('website.where_to_study');
    }

    public function checkcert()
    {
        return view('website.checkcert');
    }
    
    
public function checkCertificate(Request $request)
{ 
    // Validate input
    $request->validate([
        'certificate_number' => 'required|string',
    ]); 

    // Query with specific fields from both tables
    $checkcert = Certificates::select(
        'certificates.certificate_id',
        'certificates.course_name',
        'certificates.date_of_awarded',
        'student_courses.name',
        'student_courses.register_number',
        'student_courses.gender',
        'student_courses.dob',
        'student_courses.passout_year_month',
       
    )
    ->join('student_courses', 'certificates.student_id', '=', 'student_courses.id')
    ->where('certificates.certificate_id', $request->certificate_number)
    ->first();

    // If certificate found
    if ($checkcert) {
        // Optional: use gender-based salutation
        $salutation = '';
        if ($checkcert->gender === 'Male') {
            $salutation = 'Mr ';
        } elseif ($checkcert->gender === 'Female') {
            $salutation = 'Ms ';
        }

        // Format success message
        $message = 'Certificate issued to ' . $salutation . $checkcert->name . ' on ' .
                   Carbon::parse($checkcert->date_of_awarded)->isoFormat('MMMM Do, YYYY') .
                   ' for completing course ' . $checkcert->course_name . ' successfully.';

        // Redirect back with student data in session
        return redirect()->back()
            ->with('success', $message)
            ->with('student_data', [
                'name'            => $checkcert->name,
                'register_number' => $checkcert->register_number,
                'course'          => $checkcert->course_name,
                'gender'          => $checkcert->gender,
                'dob'             => Carbon::parse($checkcert->dob)->format('d-m-Y'),
                'passout'         => $checkcert->passout_year_month,
                'course_type'     => $checkcert->course_type,
            ]);
    } 

    // If not found
    return redirect()->back()->with('error', 'Certificate not issued yet for you. Please contact admin to know the issue. Your account might be blocked.');
}

    public function qualifications()
    {   
        $categories = Categories::select('category_name','slug','cover_image')
        ->where('status','=','1')
        ->get();

        return view('website.qualifications',compact('categories'));
    }

    public function corporateTraining()
    {
        $corporate_categories = CorporateCategories::select('category_name','slug','cover_image')
        ->where('status','=','1')
        ->get();

        return view('website.corporate_training',compact('corporate_categories'));
    }


    public function corporateTrainingDetails($slug)
    {
        $details = CorporateCategories::select('corporate_categories.*')
        ->where('slug','=',$slug)
        ->with(['corporateCourse' => function($query)
        {
            $query->where('status','=','1');
        }])
        ->first();

        if($details == null){
            return abort(404);
        }

        return view('website.corporate_training_details',compact('details'));
    }

    public function qualificationsDetails($slug)
    {
        $details = Categories::select('categories.*')
        ->where('slug','=',$slug)
        ->with(['Exams','OnlineCourse' => function($query)
        {
            $query->where('status','=','1');
        }])
        ->first();

        if($details == null){
            return abort(404);
        }

        return view('website.qualification_details',compact('details'));
    }


    public function examDetails($slug)
    {
        $exam = Exams::where('slug','=',$slug)->first();
        if($exam == null){
            return abort(404);
        }
        return view('website.exam_details',compact('exam'));
    }

    public function courseDetails($slug)
    {
        $course = OnlineCourse::where([['slug','=',$slug],['status','=','1']])->first();
        if($course == null){
            return abort(404);
        }
        return view('website.course_details',compact('course'));
    }


    public function corporateTrainingCourseDetails($slug)
    {
        $course = CorporateCourses::where([['slug','=',$slug],['status','=','1']])->first();
        if($course == null){
            return abort(404);
        }
        return view('website.corporate_training_course_details',compact('course'));
    }

    public function CourseBroucher($slug)
    {
         $course = OnlineCourse::where([['slug','=',$slug],['status','=','1']])->first();
        if($course == null){
            return abort(404);
        }
       return  Storage::disk('public')->download($course->pdf,'brochure.pdf');
    }

    public function corporateTrainingBroucher($slug)
    {
        $course = CorporateCourses::where([['slug','=',$slug],['status','=','1']])->first();
        if($course == null){
            return abort(404);
        }

        return  Storage::disk('public')->download($course->pdf,'brochure.pdf');
    }

    public function ExamBroucher($slug)
    {
        $exam = Exams::where('slug','=',$slug)->first();
        if($exam == null){
            return abort(404);
        }
       return Storage::disk('public')->download($exam->pdf,'brochure.pdf');
    }

    public function newsEvents()
    {
        $news_events = NewsAndEvents::orderBy('created_at', 'DESC')->simplePaginate(6);
        return view('website.news_events',compact('news_events'));
    }

     public function newsEventsDetails($slug)
    {
        $news_event = NewsAndEvents::where('slug','=',$slug)->first();
        return view('website.news_events_inner',compact('news_event'));
    }

    public function BecomeCenter()
    {
        $centers = Centers::where('status','=','1')->pluck('id','study_center_name');
        $course = OnlineCourse::where('status','=','1')->pluck('id','course_name');

        return view('website.become_center_application',compact('centers','course'));
    }

    public function ApplyNowMail(Request $request)
    {
        $this->validate($request,[
      'name' => 'required',
      'email' => 'required',
      'contact_number' => 'required',
      'center' => 'required',
      'course' => 'required',
      'message' => 'required'
    ]);
    
     $enquiry = StudentEnquiry::create([
        'name' => $request->name,
        'email' => $request->email,
        'contact_number' => $request->contact_number,
        'center_id' => $request->center,
        'course_id' => $request->course,
        'message' => $request->message,
        'dob' => $request->dob ?? null,
    ]);
        $center = Centers::findOrFail($request->center);
        $course = OnlineCourse::findOrFail($request->course);

        $mail = env('TO_MAIL');
        Mail::to($mail)->send(new CenterRequestSendMail($request,$course->course_name,$center->study_center_name));

        $send_to_mail = $center->study_center_email;
        Mail::to($send_to_mail)->send(new StudentEnquiryToCenter($request,$course->course_name,$center->study_center_name));

        return redirect(route('success'));
    }

    public function success()
    {
        return view('website.success');
    }

    public function findCourseProvider()
    {
        $online_course = OnlineCourse::where('status','=','1')->pluck('id','course_name');
        $locations = Location::pluck('id','location');
        $data = collect();

        return view('website.find_course',compact('online_course','locations','data'));
    }

    public function getCenter(Request $request)
    {
        $data = Centers::select('centers.*')
                ->join('center_online_courses','centers.id','center_online_courses.center_id')
                ->join('online_courses','center_online_courses.course_id','online_courses.id')
                ->where([['online_courses.id','=',$request->qualification],['centers.location_id','=',$request->location],['centers.status','=','1']])
                ->get();

        $online_course = OnlineCourse::where('status','=','1')->pluck('id','course_name');
        $locations = Location::pluck('id','location');

        return view('website.find_course',compact('online_course','locations','data'));
    }


    public function findExaminations()
    {
        $exam = Exams::pluck('id','exam_name');
        $locations = Location::pluck('id','location');
        $data = collect();

        return view('website.find_exam',compact('exam','locations','data'));
    }

    public function getExamCenter(Request $request)
    {
            $data = Centers::select('centers.*')
                ->join('center_exams','centers.id','center_exams.center_id')
                ->join('exams','center_exams.exam_id','exams.id')
                ->where([['exams.id','=',$request->exam],['centers.location_id','=',$request->location],['centers.status','=','1']])
                ->get();

        $exam = Exams::pluck('id','exam_name');
        $locations = Location::pluck('id','location');

        return view('website.find_exam',compact('exam','locations','data'));
    }

    public function courseCalendar()
    {
        $calendar = CourseCalendar::all();
        return view('website.course_calendar',compact('calendar'));
    }
    
    public function placementList()
    {
        $placements = Placement::latest()->get();
        return view('website.placements', compact('placements'));
    }


    public function getCourseByCenter($id)
    {
        $course = CenterOnlineCourse::where([['center_online_courses.center_id', $id],['online_courses.status','=','1']])
        ->join('online_courses','center_online_courses.course_id','online_courses.id')
        ->pluck('online_courses.course_name','online_courses.id');
        $courses = '';

        foreach ($course as $key => $value) {
            $courses .= '<option value="'.$key.'">'.$value.'</option>';
        };

        return $courses;
    }
    
     public function placementapplyForm($id)
    {
        $placement = Placement::findOrFail($id);
        return view('website.placement_apply_form', compact('placement'));
    }

    public function placementstore(Request $request)
    {
       $request->validate([
        'placement_id' => 'required',
        'name' => 'required|string|max:255',
        'email' => 'required',
        'experience' => 'required|string|max:255',
        'qualification' => 'required|string|max:255',
        'resume' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:5000'
    ]);

    // Upload Resume
    if ($request->hasFile('resume')) {
        $resumeName = time() . '.' . $request->resume->getClientOriginalExtension();
        $request->resume->move(public_path('uploads/resume'), $resumeName);
    }

    $application = PlacementApplication::create([
        'placement_id' => $request->placement_id,
        'name' => $request->name,
        'experience' => $request->experience,
        'qualification' => $request->qualification,
        'resume' => $resumeName,
        'email'  => $request->email,
    ]);

    // SEND MAIL
    $mail = env('TO_MAIL'); // admin email
    Mail::to($mail)->send(new PlacementApplyMail($application));
    Mail::to($request->email)->send(new \App\Mail\PlacementApplicationConfirmationMail($application));

    return redirect()->route('success')->with('success', 'Application submitted successfully!');
    }
    
    public function videotestimonials()
    {
        $videos = VideoTestimonial::where('status', 1)
                    ->latest()
                    ->get();
    
        return view('website.video_testimonials', compact('videos'));
    }
    
}

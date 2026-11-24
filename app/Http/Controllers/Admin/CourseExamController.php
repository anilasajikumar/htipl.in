<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CourseExam;
use App\Models\CourseModule;
use App\Models\OnlineCourse;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Toastr;
use Yajra\Datatables\Datatables;

class CourseExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.course_exam.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$category = Categories::where('type','!=','Exam')->pluck('id','category_name');
    	$course = OnlineCourse::pluck('id','course_name');
    	// $course_module = CourseModule::pluck('id','course_module_name');
        return view('admin.course_exam.create',compact('course','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course' => 'required|unique:course_exams,course_id',
            'exam_name' => 'required|string|max:255',
            'exam_description' => 'required',
            'total_questions' => 'required|integer',
            'mark_per_question' => 'required',
            'minus_mark_per_question' => 'required',
            'pass_mark' => 'required',
            'total_time' => 'required|integer',
        ]);

        if ($request->hasFile('answer_key')){
        $answer_key_path = Storage::disk('public')->put('answer_keys', $request->file('answer_key'));
       }

        $course_exam = new CourseExam;
        $course_exam->course_id = $request->course;
        $course_exam->exam_name = $request->exam_name;
        $course_exam->exam_description = $request->exam_description;
        $course_exam->total_questions = $request->total_questions;
        $course_exam->mark_per_question = $request->mark_per_question;
        $course_exam->minus_mark_per_question = $request->minus_mark_per_question;
        $course_exam->pass_mark = $request->pass_mark;
        $course_exam->total_marks = $request->total_questions*$request->mark_per_question;
        $course_exam->total_time = $request->total_time;
        $course_exam->save();

        Toastr::success('Exam Successfully Created', 'Success');
        return redirect(route('course-exam.questions',$course_exam->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $course_exam = CourseExam::select('course_exams.*','online_courses.course_name')
        ->join('online_courses','course_exams.course_id','online_courses.id')
        ->get();
        return Datatables::of($course_exam)->addColumn('questions', function ($course_exam) {
               return '<a href="'.route('course-exam.questions',$course_exam->id).'" class="btn btn-primary btn-fw">View Questions</a>';
           })->addColumn('edit', function ($course_exam) {
               return '<a href="'.route('course-exam.edit',$course_exam->id).'" class="btn btn-info btn-fw">Edit</a>';
           })
        ->addColumn('action', function ($course_exam) {
               return '<span data-url="'.route('course-exam.destroy',$course_exam->id).'"class="btn btn-danger btn-fw deteting-btn">Delete</span>';
           })->rawColumns(['questions','edit','action'])
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
        $course_exam = CourseExam::findOrFail($id);
    	// $course_module = CourseModule::where('id','=',$course_exam->course_module_id)->pluck('id','course_module_name');

    	// $selected_course_module = CourseModule::where('id','=',$course_exam->course_module_id)->first();
    	$selected_course = OnlineCourse::where('id','=',$course_exam->course_id)->first();
    	$course = OnlineCourse::where('id','=',$course_exam->course_id)->pluck('id','course_name');
    	$category = Categories::where('type','!=','Exam')->pluck('id','category_name');
    	

        return view('admin.course_exam.edit',compact('category','course','course_exam','selected_course'));
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
        $this->validate($request, [
            'course' => 'required|unique:course_exams,course_id,'.$id,
            'exam_name' => 'required|string|max:255',
            'exam_description' => 'required',
            'total_questions' => 'required|integer',
            'mark_per_question' => 'required',
            'minus_mark_per_question' => 'required',
            'pass_mark' => 'required',
            'total_time' => 'required|integer',
        ]);

        if ($request->hasFile('answer_key')){
        $answer_key_path = Storage::disk('public')->put('answer_keys', $request->file('answer_key'));
       }

        $course_exam = CourseExam::findOrFail($id);
        $course_exam->course_id = $request->course;
        $course_exam->exam_name = $request->exam_name;
        $course_exam->exam_description = $request->exam_description;
        $course_exam->total_questions = $request->total_questions;
        $course_exam->mark_per_question = $request->mark_per_question;
        $course_exam->minus_mark_per_question = $request->minus_mark_per_question;
        $course_exam->pass_mark = $request->pass_mark;
        $course_exam->total_marks = $request->total_questions*$request->mark_per_question;
        $course_exam->total_time = $request->total_time;
        $course_exam->save();

        Toastr::success('Exam Successfully Updated', 'Success');
        return redirect(route('course-exam.questions',$course_exam->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CourseExam::findOrFail($id)->delete();
        Toastr::error('Exam Successfully Removed', 'Success');
        return redirect()->back();
    }

    public function addQuestions($id)
    {
    	$course_exam = CourseExam::findOrFail($id);
    	// $course_module = CourseModule::select('id','course_module_name','course_id')
    	// ->where('course_modules.id','=',$course_exam->course_module_id)
    	// ->first();
    	$course = OnlineCourse::select('id','course_name')
    	->where('id','=',$course_exam->course_id)
    	->first();

    	return view('admin.course_exam.questions.create',compact('course_exam','course'));
    }

    public function saveQuestions(Request $request,$id)
    {
    	$this->validate($request,[
    		'question'=>'required',
    		'option_a'=>'required',
    		'option_b'=>'required',
    		'option_c'=>'required',
    		'option_d'=>'required',
    		'answer'=>'required',
    		'image'=>'mimes:jpeg,jpg,png,gif|nullable|max:2128'
    	]);

    	$course_exam = CourseExam::findOrFail($id);
    	if($course_exam == null){
    		return abort(404);
    	}

    	if ($request->hasFile('image')){
            $path = Storage::disk('public')->put('questions_images', $request->file('image'));
        }

        //CHECK NUMBER OF QUESTIONS EXCEED
        $question_under_exam = Questions::where('course_exam_id','=',$course_exam->id)->get();
        if($course_exam->total_questions <= $question_under_exam->count()){
        	Toastr::error('Total Question Limit Exceed', 'Error');
        	return redirect()->back();
        }
        //END

    	$questions = new Questions;
    	$questions->course_exam_id = $id;
    	$questions->question = $request->question;
    	$questions->option_a = $request->option_a;
    	$questions->option_b = $request->option_b;
    	$questions->option_c = $request->option_c;
    	$questions->option_d = $request->option_d;
    	$questions->answer = $request->answer;
    	if ($request->hasFile('image')){
    	$questions->image = $path;
        }
    	$questions->save();

    	Toastr::success('Questions Created Successfully', 'Success');
        return redirect()->back();
    }


    public function QuestionsData($id)
    {
    	$questions = Questions::select('questions.*')->where('course_exam_id','=',$id)->get();
        return Datatables::of($questions)->addColumn('edit', function ($questions) {
               return '<a href="'.route('question.edit',$questions->id).'" class="fas fa-edit"></a>';
           })
       ->addColumn('action', function ($questions) {
               return '<span data-url="'.route('question.destroy',$questions->id).'"class="fas fa-trash deteting-btn"></span>';
           })->rawColumns(['edit','action'])
       ->addIndexColumn()
       ->make(true);
    }

    public function viewDeletedCourseExam()
    {
        return view('admin.course_exam.deleted');
    }

    public function getDeletedCourseExam()
    {
        $course_exam = CourseExam::onlyTrashed()
        ->select('course_exams.*','online_courses.course_name')
        ->join('online_courses','course_exams.course_id','online_courses.id')
        ->get();

        return Datatables::of($course_exam)->addColumn('restore', function ($course_exam) {
               return '<span data-url="'.route('course-exam.restore',$course_exam->id).'"class="btn btn-danger btn-fw deteting-btn">Restore</span>';
           })->rawColumns(['restore','questions'])
        ->addIndexColumn()
        ->make(true);
    }

    public function Restore($id)
    {
        CourseExam::withTrashed()->find($id)->restore();
        return redirect(route('course-exam.index'));
    }
}

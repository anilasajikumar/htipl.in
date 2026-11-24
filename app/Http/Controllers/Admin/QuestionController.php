<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseExam;
use App\Models\CourseModule;
use App\Models\OnlineCourse;
use App\Models\Questions;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class QuestionController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $questions = Questions::findOrFail($id);
        $course_exam = CourseExam::findOrFail($questions->course_exam_id);
        // $course_module = CourseModule::select('id','course_module_name','course_id')
        // ->where('course_modules.id','=',$course_exam->course_module_id)
        // ->first();
        $course = OnlineCourse::select('id','course_name')
        ->where('id','=',$course_exam->course_id)
        ->first();
        return view('admin.course_exam.questions.edit',compact('questions','course_exam','course'));
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
            'question'=>'required',
            'option_a'=>'required',
            'option_b'=>'required',
            'option_c'=>'required',
            'option_d'=>'required',
            'answer'=>'required',
            'image'=>'mimes:jpeg,jpg,png,gif|nullable|max:2128'
        ]);

        $questions = Questions::findOrFail($id);

        $course_exam = CourseExam::findOrFail($questions->course_exam_id);
        if($course_exam == null){
            return 'a';
        }

        if ($request->hasFile('image')){
            $path = Storage::disk('public')->put('questions_images', $request->file('image'));
        }

        $questions->course_exam_id = $course_exam->id;
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

        Toastr::success('Questions Successfully Updated', 'Success');
        return redirect(route('course-exam.questions',$questions->course_exam_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Questions::findOrFail($id)->delete();
        Toastr::error('Question Successfully Removed', 'Success');
        return redirect()->back();
    }
}

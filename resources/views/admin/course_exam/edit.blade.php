@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Courses Exam</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('course-exam.update',$course_exam->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Create Course Exam</h4>
                  </div>

                  <div class="card-body">

                   

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }} selectric" id="category" name="category" required>
                          @foreach($category as $key => $value)
                          <option value="{{$value}}" @if($selected_course->category_id == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('category') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('course') ? ' is-invalid' : '' }} selectric" id="course" name="course" required>
                          @foreach($course as $key => $value)
                          <option value="{{$value}}" @if($course_exam->course_id == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('course') }}</small>
                      </div>
                    </div>


{{--                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Module</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" id="course_module" name="course_module">
                          @foreach($course_module as $key => $value)
                          <option value="{{$value}}" @if($course_exam->course_module_id == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> --}}

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="exam_name" value="{{$course_exam->exam_name}}" required class="form-control {{ $errors->has('exam_name') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('exam_name') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea value="{{$course_exam->exam_description}}" required class="form-control {{ $errors->has('exam_description') ? ' is-invalid' : '' }}" name="exam_description" rows="100">{!! $course_exam->exam_description !!}</textarea>
                        <small class="text-danger">{{ $errors->first('exam_description') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Question <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="total_questions" value="{{$course_exam->total_questions}}" required class="form-control {{ $errors->has('total_questions') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('total_questions') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Time (Minutes) <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="total_time" value="{{$course_exam->total_time}}" required class="form-control {{ $errors->has('total_time') ? ' is-invalid' : '' }}">
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mark Per Question <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="mark_per_question" value="{{$course_exam->mark_per_question}}" step="any" required class="form-control {{ $errors->has('mark_per_question') ? ' is-invalid' : '' }}">
                         <small class="text-danger">{{ $errors->first('mark_per_question') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Minus Per Question <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="minus_mark_per_question" value="{{$course_exam->minus_mark_per_question}}" required step="any" class="form-control {{ $errors->has('minus_mark_per_question') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('minus_mark_per_question') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pass Mark <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" step="any" name="pass_mark" value="{{$course_exam->pass_mark}}" required class="form-control {{ $errors->has('pass_mark') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('pass_mark') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Answer Key</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="answer_key" class="form-control">
                      </div>
                    </div>

                    


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <a href=""><button class="btn btn-primary" type="submit">Submit</button></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </section>

      </div>

@endsection
@section('script')
<script type="text/javascript">
$(function () {
    $('#category').change(function(e) {
        e.preventDefault();   
        var category = $('#category').val();
        $.ajax({
            url: '/dashboard/category/course/'+category,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(data) {
            $('#course').html();
            var html = '<option value="">----Select----</option>';
            html += data;
            $('#course').html(html);
            
        })
        .fail(function() {
        })
        .always(function() {
        });
        
    });
// $('#course').change(function(e) {
//         e.preventDefault();   
//         var course = $('#course').val();
//         $.ajax({
//             url: '/dashboard/course/course-module/'+course,
//             type: 'GET',
//             dataType: 'html',
//         })
//         .done(function(data) {
//             $('#course_module').html();
//             $('#course_module').html(data);
//         })
//         .fail(function() {
//         })
//         .always(function() {
//         });
        
//     });

});
</script>
@endsection
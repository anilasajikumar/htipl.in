@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Course</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('corporate-course.update',$course->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Edit Corporate Course</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" required>
                          @foreach($category as $key => $value)
                          <option value="{{$value}}" @if(old('category') == $value) selected @elseif($course->category_id == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('category') }}</small>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="course_name" class="form-control {{ $errors->has('course_name') ? ' is-invalid' : '' }}" value="{{$course->course_name}}" required>
                        <small class="text-danger">{{ $errors->first('course_name') }}</small>
                      </div>
                    </div>
               
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('course_description') ? ' is-invalid' : '' }}" name="course_description" required>{!! $course->course_description !!}</textarea>
                        <small class="text-danger">{{ $errors->first('course_description') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Duration (Days) <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" name="course_duration" class="form-control {{ $errors->has('course_duration') ? ' is-invalid' : '' }}" value="{{$course->course_duration}}" required>
                        <small class="text-danger">{{ $errors->first('course_duration') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Fee <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" name="course_fee" class="form-control {{ $errors->has('course_fee') ? ' is-invalid' : '' }}" value="{{$course->course_fee}}" required>
                        <small class="text-danger">{{ $errors->first('course_fee') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pdf</label>
                      <div class="col-sm-12 col-md-7">
                        @if($course->pdf != null)
  <iframe src="{{asset('/storage/'.$course->pdf)}}" style="width:500px;height:500px /"></iframe>
   @endif
<input type="file" name="pdf" class="form-control{{ $errors->has('pdf') ? ' is-invalid' : '' }}" value="{{$course->pdf}}" accept="application/pdf">
 <small class="text-danger">{{ $errors->first('pdf') }}</small>
                      </div>
                    </div>

                   {{--  <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">View Status</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="radio" name="status" value="1" @if($course->status == '1') checked="checked" @endif required> Yes 
                        <input type="radio" name="status" value="0" @if($course->status == '0') checked="checked" @endif required> No 
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                      </div>
                    </div> --}}

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Update</button>
                      </div>
                    </div>
                    
                  </div>
                </form>
                </div>
              </div>
            </div>

        </section>

      </div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace( 'course_description' );</script>
@endsection
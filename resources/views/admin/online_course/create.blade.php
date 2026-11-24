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
                  <form method="POST" action="{{route('online-course.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                  <div class="card-header">
                    <h4>Create Online Course</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" required>
                          <option value="" selected>Choose Category</option>
                          @foreach($category as $key => $value)
                          <option value="{{$value}}" @if(old('category') == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('category') }}</small>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="course_name" class="form-control {{ $errors->has('course_name') ? ' is-invalid' : '' }}" required value="{{old('course_name')}}">
                        <small class="text-danger">{{ $errors->first('course_name') }}</small>
                      </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Code <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="course_code" class="form-control {{ $errors->has('course_code') ? ' is-invalid' : '' }}" required value="{{old('course_code')}}">
                        <small class="text-danger">{{ $errors->first('course_code') }}</small>
                      </div>
                    </div>
               
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('course_description') ? ' is-invalid' : '' }}" name="course_description" required>{{old('course_description')}}</textarea>
                        <small class="text-danger">{{ $errors->first('course_description') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Duration (Days) <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" name="course_duration" class="form-control {{ $errors->has('course_duration') ? ' is-invalid' : '' }}" required value="{{old('course_duration')}}">
                        <small class="text-danger">{{ $errors->first('course_duration') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Fee <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" name="course_fee" class="form-control {{ $errors->has('course_fee') ? ' is-invalid' : '' }}" required value="{{old('course_fee')}}">
                        <small class="text-danger">{{ $errors->first('course_fee') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pdf</label>
                      <div class="col-sm-12 col-md-7">
                        <input id="fileupload" type="file" class="form-control {{ $errors->has('pdf') ? ' is-invalid' : '' }}" name="pdf" accept="application/pdf">
                        <small class="text-danger">{{ $errors->first('pdf') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Link</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="url" name="exam_link" class="form-control {{ $errors->has('exam_link') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('exam_link') }}</small>
                      </div>
                    </div>

                   {{--  <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">View Status</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="radio" name="status" value="1" required> Yes 
                        <input type="radio" name="status" value="0" required> No 
                        <small class="text-danger">{{ $errors->first('status') }}</small>
                      </div>
                    </div> --}}

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Submit</button>
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
@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Exam</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{route('course-calender.update',$course_calender->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Create Exam</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="course_name" value="{{$course_calender->course_name}}" class="form-control {{ $errors->has('course_name') ? ' is-invalid' : '' }}" required>
                        <small class="text-danger">{{ $errors->first('course_name') }}</small>
                      </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Starting Date <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" name="starting_date" required value="{{$course_calender->starting_date}}" class="form-control {{ $errors->has('starting_date') ? ' is-invalid' : '' }}">
                          <small class="text-danger">{{ $errors->first('starting_date') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Location <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="location" value="{{$course_calender->location}}" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" required>
                        <small class="text-danger">{{ $errors->first('location') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Date <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" name="exam_date" required value="{{$course_calender->exam_date}}" class="form-control {{ $errors->has('exam_date') ? ' is-invalid' : '' }}">
                          <small class="text-danger">{{ $errors->first('exam_date') }}</small>
                      </div>
                    </div>


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
<script>CKEDITOR.replace( 'exam_description' );</script>
@endsection
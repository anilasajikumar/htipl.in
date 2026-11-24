@extends('layouts.center.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Register Students To Exam</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                <form method="POST" action="{{route('study-center-exam.register')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                  <div class="card-body">
                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Name</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control {{ $errors->has('exam_name') ? ' is-invalid' : '' }}" name="exam_name" value="{{$exams->exam_name}}" readonly>
                         <small class="text-danger">{{ $errors->first('exam_name') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Student Name</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="name" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name')}}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="email" required class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('email')}}">
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="mobile" required class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{old('mobile')}}">
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">DOB</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" name="dob" required class="form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" value="{{old('dob')}}">
                        <small class="text-danger">{{ $errors->first('dob') }}</small>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gender</label>
                      <div class="col-sm-12 col-md-7">
                        <label class="radio-inline">
                        <input type="radio" name="gender" value="male" checked> Male
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="gender" value="female"> Female
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="gender" value="other"> Others
                        </label>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address</label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{old('address')}}" name="address" required>{!! old('address') !!}</textarea>
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                      </div>
                    </div>

              {{--       <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Proof</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" class="form-control">
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
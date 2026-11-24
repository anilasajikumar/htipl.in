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
                    <form method="POST" action="{{route('exam.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                  <div class="card-header">
                    <h4>Create Exam</h4>
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
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Type <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" required>
                          <option value="" selected>Choose Type</option>
                          @foreach(Config::get('enum.exam_type') as $key => $value)
                          <option value="{{$value}}" @if(old('type') == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('type') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="exam_name" value="{{old('exam_name')}}" class="form-control {{ $errors->has('exam_name') ? ' is-invalid' : '' }}" required>
                        <small class="text-danger">{{ $errors->first('exam_name') }}</small>
                      </div>
                    </div>
                    
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea name="exam_description" class="form-control {{ $errors->has('exam_description') ? ' is-invalid' : '' }}" rows="100" required>{!! old('exam_description') !!}</textarea>
                        <small class="text-danger">{{ $errors->first('exam_description') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Register Before (Days) <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" name="register_before_days" class="form-control {{ $errors->has('register_before_days') ? ' is-invalid' : '' }}" value="{{old('register_before_days')}}" required>
                        <small class="text-danger">{{ $errors->first('register_before_days') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Fee <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" min="0" name="exam_fee" value="{{old('exam_fee')}}" required class="form-control {{ $errors->has('exam_fee') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('exam_fee') }}</small>
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
<script>CKEDITOR.replace( 'exam_description' );</script>
@endsection
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
                    <form method="POST" action="{{route('exam-unit.update',$exam_unit->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Create Exam</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('exam') ? ' is-invalid' : '' }}" name="exam" required>
                          <option value="" selected>Choose Exam</option>
                          @foreach($exam as $exams)
                          <option value="{{$exams->id}}" @if($exam_unit->exam_id == $exams->id) selected @endif>{{$exams->exam_name}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('exam') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Unit Code <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="unit_code" value="{{$exam_unit->unit_code}}" class="form-control {{ $errors->has('unit_code') ? ' is-invalid' : '' }}" required>
                        <small class="text-danger">{{ $errors->first('unit_code') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Unit Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="unit_name" value="{{$exam_unit->unit_name}}" class="form-control {{ $errors->has('unit_name') ? ' is-invalid' : '' }}" required>
                        <small class="text-danger">{{ $errors->first('unit_name') }}</small>
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
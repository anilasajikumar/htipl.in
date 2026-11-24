@extends('layouts.admin.layout')
@section('content')
  
<div class="main-content">
    <section class="section">
          <div class="section-header">
            <h1>Study Center Exam</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('center-exam.update',$center_exam->id)}}" enctype="multipart/form-data">
  {{csrf_field()}}
  {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Assign Exam</h4>
                  </div>

                  <div class="card-body">

                   

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric {{ $errors->has('exam') ? ' is-invalid' : '' }}" name="exam" required>
                          @foreach($exam as $key => $value)
                          <option value="{{$value}}" @if($center_exam->exam_id == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('exam') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric {{ $errors->has('center') ? ' is-invalid' : '' }}" name="center" required>
                           @foreach($center as $key => $value)
                          <option value="{{$value}}" @if($center_exam->center_id == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('center') }}</small>
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
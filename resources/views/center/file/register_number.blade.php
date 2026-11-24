@extends('layouts.center.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>File</h1>
          </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
             <form method="POST" action="{{route('update_student_register',$student_id->id)}}" enctype="multipart/form-data">
              {{csrf_field()}}
                <div class="card-header">
                      <h4>Upload File For - {{ $student_id->name }}</h4>
                </div>
         <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Register Number</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="register_number" @if($find_reg_number != null) value="{{ $find_reg_number->register_number }}" @else value="{{old('register_number')}}" @endif class="form-control {{ $errors->has('register_number') ? ' is-invalid' : '' }}">
              <small class="text-danger">{{ $errors->first('register_number') }}</small>
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
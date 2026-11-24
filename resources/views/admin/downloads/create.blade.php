@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Download File</h1>
          </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
             <form method="POST" action="{{route('downloads.store')}}" enctype="multipart/form-data">
              {{csrf_field()}}
                <div class="card-header">
                      <h4>Download File</h4>
                </div>
         <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="title" value="{{old('title')}}" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
              <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File</label>
            <div class="col-sm-12 col-md-7">
              <input type="file" name="file" value="{{old('file')}}" accept="application/pdf" class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }}">
             <small class="text-danger">{{ $errors->first('file') }}</small>
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
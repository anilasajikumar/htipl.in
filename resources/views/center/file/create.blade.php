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
             <form method="POST" action="{{route('center_student_files_store',$student_id->id)}}" enctype="multipart/form-data">
              {{csrf_field()}}
              {{method_field('PATCH')}}
                <div class="card-header">
                      <h4>Upload File For - {{ $student_id->name }}</h4>
                </div>
         <div class="card-body">
          {{-- @if($find_reg_number == null) 
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Register Number</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="register_number" value="{{old('register_number')}}" class="form-control {{ $errors->has('register_number') ? ' is-invalid' : '' }}">
              <small class="text-danger">{{ $errors->first('register_number') }}</small>
            </div>
          </div>
          @endif --}}
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="title" required value="{{old('title')}}" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
              <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File</label>
            <div class="col-sm-12 col-md-7">
              <input type="file" name="file" required value="{{old('file')}}" accept="application/pdf" class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }}">
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
@if(!$files->isempty())
<div class="row">
  <div class="col-md-12">
  <div class="card">
      <div class="card-body">
      <div class="table-responsive">
      <table class="table cell-border hover stripe " id="files_table">
        <thead class=" text-primary">
          <tr>
            <th>
            TITLE                      
              </th>
              <th>
            DOWNLOAD                      
              </th>
          </tr>
        </thead>
        <tbody>
          @foreach($files as $file)
          <tr>
            <td> {{ $file->title }}</td>
            <td><a class="bs-video-description" href="{{asset('/storage/'.$file->pdf)}}" download><button class="btn btn-primary">Download</button></a></td>
          </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>
</div>
@endif
        </section>

      </div>
@endsection
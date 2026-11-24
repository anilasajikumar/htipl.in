@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Upload Result File</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                <form method="POST" action="{{route('result_files.save',$student_id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                  <div class="card-header">
                    <h4>Result File</h4>
                  </div>

                  <div class="card-body">

                   

                      <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Result</label>
  <div class="col-sm-12 col-md-7">
  <input type="file" name="file" value="{{old('file')}}" class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }}">
   @foreach ($errors->all() as $error)
  <small class="text-danger">{{ $error }}</small>
  @endforeach
  </div>
  </div>
  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Result</label>
  <div class="col-sm-12 col-md-7">
  <input type="radio" name="result" value="pass" @if($files->result == 'pass') checked @endif required> Pass
  &nbsp;
  <input type="radio" name="result" value="fail" @if($files->result == 'fail') checked @endif required> Fail
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
              @if($files->file != null)
              <iframe src="{{asset('/storage/'.$files->file)}}" style="width:500px;height:500px /"></iframe>
              @endif
                </div>
              </div>
            </div>

        </section>

      </div>
@endsection
@extends('layouts.center.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Upload Answer Sheets</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                <form method="POST" action="{{route('answer_files.save',$student_id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                  <div class="card-header">
                    <h4>Upload Answer Sheets</h4>
                  </div>

                  <div class="card-body">

                   

                      <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Answer Sheet</label>
  <div class="col-sm-12 col-md-7">
  <input type="file" name="file[]" multiple="multiple" value="{{old('file')}}" class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }}">
   @foreach ($errors->all() as $error)
  <small class="text-danger">{{ $error }}</small>
  @endforeach
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
              @if($files != null)
              <div class="container">
              <div class="row">
              @foreach($files as $file)
              <div class="col">
              <iframe src="{{asset('/storage/'.$file->file)}}" style="width:300px;height:300px /"></iframe>
              <form method="Post" action="{{ route('answer_sheet.delete',$file->id) }}">
        @csrf
{{ method_field('DELETE') }}
        <button onclick="return confirm('Are you sure you want to delete this item ??')" name="submit" class="btn btn-icon btn-danger"><i class="fas fa-trash-alt"></i></button></form>
              </div>
              @endforeach
            </div>
          </div>
              @endif
                </div>
              </div>
            </div>

        </section>

      </div>
@endsection
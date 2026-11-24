@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Uploaded Answer Files</h1>
          </div>
              <div class="row">
              <div class="col-12">
                <div class="card">
              @if($files != null)
              <div class="container">
              <div class="row">
              @foreach($files as $file)
              <div class="col">
              <iframe src="{{asset('/storage/'.$file->file)}}" style="width:400px;height:400px /"></iframe>
              <p class="bs-video-description">
              <a href="{{ route('download.answer_file',$file->id) }}"><button class="btn btn-danger">Download</button></a>
            </p>
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
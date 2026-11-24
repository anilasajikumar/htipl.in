@extends('layouts.student.layout')
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Files</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  @foreach($files as $file)
   <div class="col-12 col-md-6">
	<div class="bs-video-list-item">
{{--     @if($file->extension == 'mp4')
  <div class="embed-responsive embed-responsive-16by9 hoverable">
  <video class="embed-responsive-item" controls>
    <source src="{{asset('/storage/'.$file->file_path)}}" type="video/mp4">
  </video>
</div>
@endif --}}
{{-- @if($file->extension == 'pdf') --}}
	<iframe src="{{asset('/storage/'.$file->pdf)}}" style="width:400px; height:400px;" 
    frameborder="0"></iframe>
  <a class="bs-video-description" href="{{asset('/storage/'.$file->pdf)}}" download><button class="btn btn-primary">Download</button></a>
  {{-- @endif --}}
	<p class="bs-video-description">{{$file->title}}</p>
	</a>
	</div>
	</div>
  @endforeach
  </div>
  </div>
  </div>
</section>
</div>
@endsection
@section('script')
@endsection
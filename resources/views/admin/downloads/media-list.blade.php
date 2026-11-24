@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>MEDIA</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
   <div class="col-12 col-md-6">
	<div class="bs-video-list-item">
	<iframe src="{{asset('/storage/'.$download->pdf)}}" style="width:400px; height:400px;" 
    frameborder="0"></iframe>
  <a class="bs-video-description" href="{{asset('/storage/'.$download->pdf)}}" download><button class="btn btn-primary">Download</button></a>
	<p class="bs-video-description">{{$download->title}}</p>
	</a>
	</div>
	</div>
  </div>
  </div>
  </div>
</section>
</div>
@endsection
@section('script')
@endsection
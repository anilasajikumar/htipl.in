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
	    {{-- PDF --}}
@if($course_media->extension === 'pdf' && !empty($course_media->pdf_link))

    @php
        $pdfUrl = str_starts_with($course_media->pdf_link, 'http')
            ? $course_media->pdf_link
            : asset('storage/'.$course_media->pdf_link);
    @endphp

    <iframe
        src="{{ $pdfUrl }}"
        style="width:100%; height:600px;"
        frameborder="0">
    </iframe>

    <a href="{{ $pdfUrl }}"
       class="btn btn-primary mt-2"
       target="_blank">
        Open / Download PDF
    </a>
@endif


{{-- YouTube Video --}}
@if(!empty($course_media->link))
    @php
        $videoUrl = $course_media->link;
        $embedUrl = '';

        if (str_contains($videoUrl, 'youtu.be')) {
            $videoId = trim(parse_url($videoUrl, PHP_URL_PATH), '/');
            $embedUrl = 'https://www.youtube.com/embed/'.$videoId;
        } elseif (str_contains($videoUrl, 'youtube.com')) {
            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query);
            $embedUrl = !empty($query['v'])
                ? 'https://www.youtube.com/embed/'.$query['v']
                : '';
        }
    @endphp

    <div class="mt-3">
        <iframe
            width="100%"
            height="600"
            src="{{ $embedUrl }}"
            frameborder="0"
            allowfullscreen>
        </iframe>

        <div class="text-center mt-2">
            <a href="{{ $videoUrl }}" target="_blank" class="btn btn-danger">
                ▶ Watch on YouTube
            </a>
        </div>
    </div>
@endif


<!--    @if($course_media->extension == 'mp4')-->
<!--  <div class="embed-responsive embed-responsive-16by9 hoverable">-->
<!--  <video class="embed-responsive-item" controls>-->
<!--    <source src="{{asset('/storage/'.$course_media->file_path)}}" type="video/mp4">-->
<!--  </video>-->
<!--</div>-->
<!--@endif-->
<!--@if($course_media->extension == 'pdf')-->
<!--	<iframe src="{{asset('/storage/'.$course_media->file_path)}}" style="width:400px; height:400px;" -->
<!--    frameborder="0"></iframe>-->
<!--  <a class="bs-video-description" href="{{asset('/storage/'.$course_media->file_path)}}" download><button class="btn btn-primary">Download</button></a>-->
<!--  @endif-->
	<p class="bs-video-description">{{$course_media->title}}</p>
	<p class="bs-video-description">{{$course_media->course_media_description}}</p>
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
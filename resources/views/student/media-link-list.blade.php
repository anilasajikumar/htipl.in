@extends('layouts.student.layout')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>MEDIA</h1>
            </div>
            <div class="app-content content">
                <div class="content-wrapper">
                    <div class="row">
                        @foreach($course_media as $media)
                            <div class="col-12 col-md-12">
                                <div class="bs-video-list-item">
                                    <p class="bs-video-description">{{$media->title}}</p>
                                    <p class="bs-video-description">{{$media->course_media_description}}</p>
                                    {{-- @if($media->extension == 'mp4')
                                        <div class="embed-responsive embed-responsive-16by9 hoverable">
                                            <video class="embed-responsive-item" controls controlsList="nodownload">
                                                <source src="{{asset('/storage/'.$media->file_path)}}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endif
                                    @if($media->extension == 'pdf')
                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('storage/'.$media->file_path)) }}&embedded=true" style="width:100%; height:800px;" frameborder="0"></iframe> --}}
                                        {{-- <iframe src="{{asset('/storage/'.$media->file_path)}}" style="width:400px; height:400px;" frameborder="0"></iframe> --}}
                                        {{-- <a class="bs-video-description" href="{{asset('/storage/'.$media->file_path)}}" download><button class="btn btn-primary">Download</button></a> --}}
                                    {{-- @endif --}}
                                   
                                    @if($media->link)
    
                                     @php
    $videoUrl = $media->link; 
    $videoEmbedUrl = '';
    $isDirectVideo = false;

    // Check for direct video files (MP4, WebM, OGG, AVI, MOV, etc.)
    if (preg_match('/\.(mp4|webm|ogg|avi|mov|flv|wmv)(\?.*)?$/i', $videoUrl)) {
        $isDirectVideo = true;
    }
    elseif (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
        if (str_contains($videoUrl, 'youtu.be')) {
            // Extract the last part of the URL after '/'
            $parsedUrl = parse_url($videoUrl);
            $pathParts = explode('/', $parsedUrl['path']);
            $videoId = array_pop($pathParts);
        } else {
            // Extract 'v' parameter from the query string
            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $queryParams);
            $videoId = $queryParams['v'] ?? '';
        }
        $videoEmbedUrl = "https://www.youtube.com/embed/{$videoId}";
    } elseif (str_contains($videoUrl, 'vimeo.com')) {
        // Extract the last part of the URL path
        $pathParts = explode('/', parse_url($videoUrl, PHP_URL_PATH));
        $videoId = end($pathParts);
        $videoEmbedUrl = "https://player.vimeo.com/video/{$videoId}";
    }
@endphp

@if($isDirectVideo)
    {{-- For direct video files --}}
    <div class="embed-responsive embed-responsive-16by9">
        <video class="embed-responsive-item" controls controlsList="nodownload" style="width: 100%; height: 600px;">
            <source src="{{ $videoUrl }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
@elseif($videoEmbedUrl)
    {{-- For YouTube/Vimeo embeds --}}
    <iframe
        src="{{ $videoEmbedUrl }}"
        width="100%"
        height="600"
        frameborder="0"
        allow="autoplay; fullscreen; picture-in-picture"
        allowfullscreen>
    </iframe>
@else
    <p>Invalid video URL or unsupported video platform.</p>
@endif
@endif
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
    <script type="text/javascript">
        $(document).bind("contextmenu",function(e){
        return false;
        });
    </script>
@endsection

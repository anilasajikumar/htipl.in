@extends('layouts.student.layout')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>PDF MEDIA</h1>
        </div>

        <div class="app-content content">
            <div class="content-wrapper">
                <div class="row">

                    @forelse($course_media as $media)
                        <div class="col-12 col-md-12 mb-3">
                            <div class="bs-callout-primary callout-transparent callout-bordered p-3">

                                <h5 class="mb-1">{{ $media->title }}</h5>
                                <p>{{ $media->course_media_description }}</p>

                              @if($media->link)
@php
    $videoUrl = $media->link;
    $videoEmbedUrl = '';

    if (str_contains($videoUrl, 'youtu.be')) {
        $videoId = trim(parse_url($videoUrl, PHP_URL_PATH), '/');
        $videoEmbedUrl = "https://www.youtube.com/embed/{$videoId}";
    } elseif (str_contains($videoUrl, 'youtube.com')) {
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query);
        if (!empty($query['v'])) {
            $videoEmbedUrl = "https://www.youtube.com/embed/{$query['v']}";
        }
    }
@endphp

@if($videoEmbedUrl)
    <iframe
        src="{{ $videoEmbedUrl }}"
        width="100%"
        height="600"
        frameborder="0"
        allowfullscreen>
    </iframe>

    <div class="mt-3 text-center">
        <a href="{{ $media->link }}" target="_blank" class="btn btn-danger">
            ▶ Watch on YouTube
        </a>
    </div>
@else
    <p class="text-danger">Video embedding disabled by owner.</p>
@endif
@endif


                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No PDF media found.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection

@extends('layouts.web.layout')

@section('content')

<section class="Where-To-Study_icrq">
  <div class="container">

    <h2 class="mb-5" data-aos="fade-up">
      Our <span>Students Speak</span>
    </h2>

    <div class="row">

      @forelse($videos as $video)
      <div class="col-md-12 mb-4" data-aos="fade-up">
        <div class="card mb-3">
          <div class="row no-gutters">

            <!-- VIDEO -->
            <div class="col-xl-8 col-lg-7 col-md-6">
              <div class="ratio ratio-16x9">
                <iframe 
  src="{{ str_replace('youtu.be/', 'www.youtube.com/embed/', $video->video_link) }}"
  frameborder="0"
  allowfullscreen>
</iframe>
              </div>
            </div>

            <!-- CONTENT -->
            <div class="col-xl-4 col-lg-5 col-md-6">
              <div class="card-body">
                <h5 class="card-title">{{ $video->title }}</h5>
                <hr class="card-title-line">

                <p class="card-text mt-3">
                  {{ $video->description }}
                </p>

              </div>
            </div>

          </div>
        </div>
      </div>
      @empty
      <div class="col-md-12 text-center">
        <p>No video testimonials available.</p>
      </div>
      @endforelse

    </div>

  </div>
</section>

@endsection

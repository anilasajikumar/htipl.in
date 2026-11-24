@extends('layouts.web.layout')
@section('content')
 <section class="about_icrq">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-2 ">
          <div class="col-md-12 text-left" data-aos="fade-up">
            <h2 class="mb-1">News & Events</h2>
          </div>
        </div>
        <div class="row">
        	@foreach($news_events as $news_event)
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="blog-entry">
              <a href="{{ route('news-events.details',$news_event->slug) }}" data-aos="fade-up" class="block-20 d-flex align-items-end" style="background-image: url('{{asset('/storage/'.$news_event->image)}}');">
                <div class="meta-date text-center p-2">
                  <span class="day">{{$news_event->type}}</span>
                </div>
              </a>
              <div class="text border border-top-0 p-4" data-aos="fade-up">
                <h3 class="heading"><a href="{{ route('news-events.details',$news_event->slug) }}">{{$news_event->title}}</a></h3>
                <p>{!! Str::limit($news_event->description, 100) !!}</p>
                <div class="d-flex align-items-center mt-4">
                  <p class="mb-0"><a href="{{ route('news-events.details',$news_event->slug) }}">Read More</a></p>
                  <p class="ml-auto mb-0">
                    <a href="{{ route('news-events.details',$news_event->slug) }}" class="mr-2">{{Carbon\Carbon::parse($news_event->date)->format('d M Y')}}</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
                                    <div class="col-xl-12" data-aos="fade-up">
                                        <div class="more_courses text-center">
                                            <a class="boxed_btn_rev">{{$news_events->links()}}</a>
                                        </div>
                                    </div>
        </div>
      </div>
    </section>
@endsection
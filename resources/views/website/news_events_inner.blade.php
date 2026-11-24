@extends('layouts.web.layout')
@section('content')
<section class="news-events-inner">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="mb-3" data-aos="fade-up">{{ $news_event->title }}</h2>
            <p>
              <img src="{{asset('/storage/'.$news_event->image)}}" class="img-fluid" alt="Responsive image">
            </p>
          <p>{{Carbon\Carbon::parse($news_event->date)->format('d M Y')}}</p>
            
            <p>{!! $news_event->description !!}</p>
            </div>
          </div>
        </div>
      </section>
@endsection
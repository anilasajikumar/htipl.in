@extends('layouts.web.layout')
@section('content')
<section class="qualifications_icrq">
     <div class="container">
          <h1 class="mb-5" data-aos="fade-up">{{$details->category_name}}</h1>
          <!-- <h3 class="mb-2" data-aos="fade-up">courses</h3>
          <hr class="card-title-line" data-aos="fade-up"> -->

          <p>{!! $details->description !!}</p>



<div class="list-group mt-5">
@foreach($details->corporateCourse as $courses)
@if($courses->slug != null)
  <a href="{{route('corporate_training_course_details',$courses->slug)}}" class="list-group-item list-group-item-action">{{$courses->course_name}}</a>
@endif
@endforeach
</div>


     </div>
</section>
@endsection
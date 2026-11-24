@extends('layouts.web.layout')
@section('content')
 <!-- Navbar -->
<section class="qualifications_icrq">
     <div class="container">
          <h3 class="mb-2" data-aos="fade-up">{{$course->course_name}}</h3>
          <hr class="card-title-line mb-5" data-aos="fade-up">
          {!! $course->course_description !!}
          @if($course->pdf != null)
          <a href="{{ route('corporate_course.download.broucher',$course->slug) }}" class="btn btn-large pull-right"><i class="icon-download-alt"> </i> Download Brochure </a>
          @endif
     </div>
</section>
@endsection
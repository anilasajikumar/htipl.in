@extends('layouts.web.layout')
@section('content')
 <!-- Navbar -->
<section class="qualifications_icrq">
     <div class="container">
          <h3 class="mb-2" data-aos="fade-up">{{$exam->exam_name}}</h3>
          <hr class="card-title-line mb-5" data-aos="fade-up">
          {!! $exam->exam_description !!}
          @if($exam->pdf != null)
          <a href="{{ route('exam.download.broucher',$exam->slug) }}" class="btn btn-large pull-right"><i class="icon-download-alt"> </i> Download Brochure </a>
          @endif
     </div>
</section>
@endsection
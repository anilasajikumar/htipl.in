@extends('layouts.web.layout')
@section('content')
<section class="qualifications_icrq">
     <div class="container">
          <h1 class="mb-5" data-aos="fade-up">Corporate Training</h1>
          <hr class="card-title-line" data-aos="fade-up">
          <div class="row" id="myTabContent">
          	@foreach($corporate_categories as $category)
                                    <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
                                        <div class="single_courses">
                                            <div class="thumb">
                                                <a href="{{route('corporate-training.details', $category->slug )}}">
                                                    <img src="{{asset('/storage/'.$category->cover_image)}}" class="img-fluid" alt="Responsive image">
                                                </a>
                                            </div>
                                            <div class="courses_info text-center pt-4 pb-4">
                                                <h5><a href="{{route('corporate-training.details', $category->slug )}}">{{$category->category_name}}</a></h5>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    @endforeach
                                  </div>
     </div>
</section>
@endsection
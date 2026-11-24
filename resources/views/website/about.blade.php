@extends('layouts.web.layout')
@section('content')
<section class="about_icrq">
  
  <div class="container">
    <div class="row">
    <div class="col-md-7" data-aos="fade-up">
        <h2>About HTI</h2>
	<p>HTI Pvt Ltd is a leading Safety Training and consultancy organization which providing Quality Safety Training in Ernakulam. HTIPL is supported by a highly qualified, experienced team with exceptional Safety educational backgrounds and expertise from Oil field, Construction, Engineering, Marine and Consultation.</p>
      </div>
      <div class="col-md-5" data-aos="fade-up">
        <img src="{{asset('web_dashboard/images/education_bg-2.jpg')}}" class="img-fluid" alt="Responsive image">
      </div>
    </div>
  </div>

</section>



<section class="sec2">
  
  <div class="container">
    <div class="row" style="text-align: center;">

    <div class="col-md-5 bgnd" data-aos="fade-up">
        <h5 class="mb-3">Why Study With Us?</h5>
        <p>From Last years we are in industy and have honor.</p>
    </div>

    <div class="col-md-5 bgnd" data-aos="fade-up">
        <h5 class="mb-3">Special Techniques</h5>
        <p>We are providing special visual teaching techniques to help you grow faster.</p>
    </div>

    <div class="col-md-5 bgnd" data-aos="fade-up">
        <h5 class="mb-3">Qualified Staff</h5>
        <p>Our Qualified best teachers from industry give you best professional Knowledge.</p>
    </div>

    <div class="col-md-5 bgnd" data-aos="fade-up">
        <h5 class="mb-3">Get Admission</h5>
        <p>Rush before all seats are reserved for current batch.</p>
    </div>



  </div>

</section>



<section class="about_icrqq">
  
  <div class="container">
    <div class="row">
      <div class="col-md-5" data-aos="fade-up">
        <img src="{{asset('web_dashboard/images/education_bg.jpg')}}" class="img-fluid" alt="Responsive image">
      </div>
    <div class="col-md-7" data-aos="fade-up">
         <h5 class="mb-3">Vission</h5>
        <p>To make a name for ourselves by training, auditing, consulting, and 
qualifying professionals and businesses through new ideas, and to grow with 
them in creativity, quality, productivity, teamwork, and ethical values so that 
we can all be better at what we do.</p>
  <h5 class="mb-3">Mission</h5>
        <p>To help people who want to get a good OHS degree.<br/>
To set and meet safety standards for different industries in different 
regions of the world.</p>
      </div>
      
    </div>
  </div>

</section>

 <section class="icrq_center_area">
  <div class="gray-bg"></div>
  <div class="container"> 
   <div class="row">
    <div class="col-md-6" data-aos="fade-up">  
    <h2 class="icrq_center-title">STUDENT ENQUIRY</h2>  
<!--     <p class="icrq_center-text mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
    </div>
    <div class="col-md-6" data-aos="fade-up">  
    <button class="btn Second_btn" type="submit" onclick="window.location='{{ route('apply_now.mail') }}';">APPLY NOW</button>
    </div>
   </div>
 </div>
</section>


<!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">
          <div class="row">
               <div class="col-sm-5">
                   <div class="section-title" data-aos="fade-up">
                    <div class="section-title-2">
                      <h2><span>Our</span><br>Students Speaks</h2>
                     <button class="btn Second_btn mt-4" type="submit" onclick="window.location='{{url('about')}}';">Video Testimonials</button>
                    </div>
                   </div>
                 </div>
       <div class="col-sm-7">
        <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            @foreach($testimonials as $testimonial)
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    {!! $testimonial->description !!}
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                  <h3>{{$testimonial->title}}</h3>
                  <h4>{{$testimonial->designation}}</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->
            @endforeach
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </div>

      </div>
    </section><!-- End Testimonials Section -->
@endsection

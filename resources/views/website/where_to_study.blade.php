@extends('layouts.web.layout')
@section('content')
<section class="Where-To-Study_icrq">
     <div class="container">
          <h2 class="mb-5" data-aos="fade-up">Our Centers</h2>
              <div class="row">
                    <div class="col-md-12" data-aos="fade-up">
                          <div class="card mb-3">
                               <div class="row no-gutters">
                                    <div class="col-xl-8 col-lg-7 col-md-6">
                                         <img src="{{asset('web_dashboard/images/Where-To-Study-4.jpg')}}" class="card-img" alt="responsive">
                                    </div>
                                        <div class="col-xl-4 col-lg-5 col-md-6" data-aos="fade-up">
                                             <div class="card-body">
                                                  <h5 class="card-title">Find A Course / Center</h5>
                                                  <hr class="card-title-line">
                                                       <p class="card-text mt-3"></p>
                                                       <button type="button" class="btn" onclick="window.location='{{ url('find-course-provider') }}';">Find A Course / Center</button>
                                             </div>
                                        </div>
                               </div>
                          </div> 
                  </div>
              </div>
     </div>
</section>
@endsection
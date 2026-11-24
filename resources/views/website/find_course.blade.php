@extends('layouts.web.layout')
@section('content')

   <!-- Navbar -->

<section class="Where-To-Study_icrq">
     <div class="container">
          <h2 class="mb-5" data-aos="fade-up">Find A Course Provider</h2>
              <div class="row">
                    <div class="col-md-12" data-aos="fade-up">
                          <div class="card mb-3">
                               <div class="row no-gutters">
                                    <div class="col-xl-6">
                                         <img src="{{asset('web_dashboard/images/Where-To-Study-4.jpg')}}" class="card-img" alt="responsive">
                                    </div>
                                        <div class="col-xl-6" data-aos="fade-up">
                                             <div class="find-course-form">
                             <form action="{{ route('find_center') }}" method="POST">
                             	@csrf
                                   <div class="form-group">
                                          <label>Courses</label>
                                          <select class="form-control" name="qualification" required>
                                         <option value="" selected disabled>---Select Course---</option>
                                          @foreach($online_course as $key => $value)
                                          <option value="{{ $value }}">{{ $key }}</option>
                                          @endforeach
                                          </select>        
                                   </div>

                                    <div class="form-group">
                                         <label>Location</label>
                                         <select class="form-control" name="location" required>
                                         <option value="" selected disabled>---Select Location---</option>
                                         @foreach($locations as $key => $value)
                                         <option value="{{ $value }}">{{ $key }}</option>
                                         @endforeach
                                         </select>
                                    </div>
                                    
                                     <button type="submit" class="btn mt-3">Find</button>
                             </form>
                           </div>
                       </div>
                   </div>
                </div> 
            </div>
         </div>
     </div>
</section>

@if(!$data->isEmpty())
<section>
     <div class="container">
          <h2 class="mb-5" data-aos="fade-up">Study Centers</h2>
              <div class="row find-course">
              	@foreach($data as $center)
                  <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
                       <div class="single_courses">
                          <div class="thumb">
                             <a href="#">
                               <img src="{{asset('/storage/'.$center->logo)}}" class="img-fluid" alt="Responsive image">
                              </a>
                          </div>
                          <div class="courses_info text-center pt-4 pb-2">
                            <div class="find-course-bottom text-left">
                              <h4>{{ $center->study_center_name }}</h4>
                              <p>{{ $center->study_center_email }}</p>
                              <p>{{ $center->study_center_address }}</p>
                              <p>{{ $center->study_center_mobile }}</p>
                            </div>  
                          </div>
                       </div>
                     </div>
                     @endforeach

                  </div>
               </div>
</section>
@endif

@endsection
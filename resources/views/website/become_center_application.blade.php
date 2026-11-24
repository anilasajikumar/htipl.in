@extends('layouts.web.layout')
@section('content')
<section class="about_icrq">
  
  <div class="container">
    <div class="row">
    <div class="col-md-7" data-aos="fade-up">
        <h2>Enquiry</h2>
      </div>
      <div class="col-md-5" data-aos="fade-up">
        
      </div>
    </div>
              <div class="col-md-12 mt-5" data-aos="fade-up">

                  <div class="row" data-aos="fade-up">
                        <div class="col-md-6">
                             <form action="{{ route('apply_now') }}" method="POST">
                             	@csrf
                              <h4 class="mb-5">Complete the Enquiry Form Below</h4>
                              <div class="form-group">
                                 <label>Name <span class="text-danger">*</span></label>
                                 <input type="name" name="name" class="form-control" required>               
                              </div>

                              <div class="form-group">
                                 <label>Email <span class="text-danger">*</span></label>
                                 <input type="email" name="email" class="form-control" required>
                              </div>

                              <div class="form-group">
                                 <label>Contact Number <span class="text-danger">*</span></label>
                                 <input type="number" name="contact_number" class="form-control" required>
                              </div>

                              <div class="form-group">
                                 <label>Centre <span class="text-danger">*</span></label>
                                 <select name="center" id="study_center" class="form-control" required>
                                  <option value="" selected>--Choose Center--</option>
                                  @foreach($centers as $key => $value)
                                  <option value="{{ $value }}">{{ $key }}</option>
                                  @endforeach
                                 </select>
                              </div>


                              <div class="form-group">
                                 <label>Course <span class="text-danger">*</span></label>
                                 <select name="course" id="course" class="form-control" required>
                                  <option value="" selected>--Choose Course--</option>
                                  @foreach($course as $key => $value)
                                  <option value="{{ $value }}">{{ $key }}</option>
                                  @endforeach
                                 </select>
                              </div>

                              <div class="form-group">
                                 <label>Message</label>
                                 <textarea type="text" name="message" class="form-control" required></textarea>
                              </div>

                               {{-- <input class="d-none" type="checkbox" name="terms_condition" value="Yes" checked> --}}
                               {{-- <label> <p style="font-size: 14px;"> I can confirm I have read and accepted the <a href="#">terms and conditions</a></p></label> --}}<br>
                                    
                              <button type="submit" class="btn mt-3">Submit</button>
                             </form>
                        </div>
                        
                        <div class="col-md-1"></div>

                        {{-- <div class="col-md-5">
                          <h4 class="mb-5">Courses</h4>
                          <section class="qualifications_icrq2">
                          	@foreach( $qualifications as $qualification )
                          <div class="single_courses">
                                        <div class="thumb">
                                                <a href="{{route('qualifications.details', $qualification->slug )}}">
                                                    <img src="{{asset('/storage/'.$qualification->cover_image)}}" class="img-fluid" alt="Responsive image">
                                                </a>
                                            </div>
                                            <div class="courses_info text-center pt-4 pb-4">
                                                <h5><a href="{{route('qualifications.details', $qualification->slug )}}">{{$qualification->category_name}}</a></h5>
                                            </div>
                                            
                                        </div>
                                        @endforeach

                         </section>
                        </div> --}}
              </div>                       
     </div>
  </div>

</section>
@endsection
@section('script')
<script>
  $(function () {
    $('#study_center').change(function(e) {
        e.preventDefault();   
        var study_center = $('#study_center').val();
        $.ajax({
            url: '/study-center/course/'+study_center,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(data) {
            $('#course').html();
            var html = '<option value="">----Select----</option>';
            html += data;
            $('#course').html(html);
            
        })
        .fail(function() {
        })
        .always(function() {
        });
        
    });

});
</script>
@endsection

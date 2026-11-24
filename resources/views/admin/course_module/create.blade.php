@extends('layouts.admin.layout')
@section('content')
        <div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Courses Module</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('course-module.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                  <div class="card-header">
                    <h4>Create Course Module</h4>
                  </div>

                  <div class="card-body">

                   <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }} selectric" id="category" name="category" required>
                          <option value="">----Select----</option>
                          @foreach($category as $key => $value)
                          <option value="{{$value}}">{{$key}}</option>
                          @endforeach
                        </select>
                         <small class="text-danger">{{ $errors->first('category') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('course_id') ? ' is-invalid' : '' }} selectric" id="course" name="course_id" required>
                          <option value="" selected>----Select----</option>
                          @foreach($course as $key => $value)
                          <option value="{{$value}}">{{$key}}</option>
                          @endforeach
                        </select>
                         <small class="text-danger">{{ $errors->first('course_id') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Module Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="course_module_name" required class="form-control {{ $errors->has('course_module_name') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('course_module_name') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Module Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('course_module_description') ? ' is-invalid' : '' }}" name="course_module_description" required rows="100"></textarea>
                        <small class="text-danger">{{ $errors->first('course_module_description') }}</small>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
                </div>
              </div>
            </div>

        </section>

      </div>
@endsection
@section('script')
<script type="text/javascript">
$(function () {
    $('#category').change(function(e) {
        e.preventDefault();   
        var category = $('#category').val();
        $.ajax({
            url: '/dashboard/category/course/'+category,
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
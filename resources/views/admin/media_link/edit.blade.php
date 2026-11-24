@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Media Link</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{route('media-link.update',$media_link->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Add Media Link</h4>
                  </div>

                 <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course</label>
                      <div class="col-sm-12 col-md-7" id="course">
                        <select class="form-control selectric" id="course_id" required
                        >
                          @foreach($courses as $key => $value)
                          <option value="{{$value}}" @if($media_link->course_id == $value ) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Module</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" required  name="course_module_id" id="course_module_id">
                          @foreach($courseModules as $key => $value)
                          <option value="{{$value}}" @if($media_link->course_module_id == $value ) selected @endif >{{$key}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Media Description</label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" rows="100" name="course_media_description" id="course_media_description" required>{{ $media_link->course_media_description }}</textarea>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" name="title" id="title" value="{{ $media_link->title }}" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Video Url</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="url" class="form-control" value="{{ $media_link->video_url }}" name="video_url" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Video Type</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" name="video_type" value="{{ $media_link->video_type }}" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Order</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" class="form-control" name="order" value="{{ $media_link->order }}" required>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Update</button>
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
    $('#course_id').change(function(e) {
        e.preventDefault();   
        var course = $('#course_id').val();
        $.ajax({
            url: '/dashboard/course/course-module/'+course,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(data) {
            $('#course_module_id').html();
            var html = '<option value="">----Select----</option>';
            html += data;
            $('#course_module_id').html(html);
            
        })
        .fail(function() {
        })
        .always(function() {
        });
        
    });
  });
</script>
@endsection
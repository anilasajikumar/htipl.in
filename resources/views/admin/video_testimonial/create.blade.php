@extends('layouts.admin.layout')

@section('content')
<div class="main-content">

  <section class="section">
    <div class="section-header">
      <h1>Video Testimonial</h1>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">

          <form method="POST" action="{{ route('video-testimonial.store') }}">
            @csrf

            <div class="card-header">
              <h4>Create Video Testimonial</h4>
            </div>

            <div class="card-body">

              {{-- Title --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Title <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12 col-md-7">
                  <input type="text"
                         name="title"
                         value="{{ old('title') }}"
                         required
                         class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                  <small class="text-danger">{{ $errors->first('title') }}</small>
                </div>
              </div>

              {{-- Description --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Description
                </label>
                <div class="col-sm-12 col-md-7">
                  <textarea name="description"
                            id="description"
                            class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                  <small class="text-danger">{{ $errors->first('description') }}</small>
                </div>
              </div>

              {{-- Video Link --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Video Link <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12 col-md-7">
                  <input type="url"
                         name="video_link"
                         value="{{ old('video_link') }}"
                         required
                         placeholder="https://www.youtube.com/embed/VIDEO_ID"
                         class="form-control {{ $errors->has('video_link') ? 'is-invalid' : '' }}">
                  <small class="text-danger">{{ $errors->first('video_link') }}</small>
                </div>
              </div>

              {{-- Status --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Status
                </label>
                <div class="col-sm-12 col-md-7">
                  <select name="status" class="form-control">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>

              {{-- Submit --}}
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
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.config.autoParagraph = false;
  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
  CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
  CKEDITOR.replace('description');
</script>
@endsection

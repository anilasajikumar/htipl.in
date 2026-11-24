@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Testimonial</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('testimonial.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                  <div class="card-header">
                    <h4>Create Testimonial</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="title" value="{{old('title')}}" required class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('title') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Designation <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="designation" value="{{old('designation')}}" required class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('designation') }}</small>
                      </div>
                    </div>

               
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required id="description">{!! old('description') !!}</textarea>
                        <small class="text-danger">{{ $errors->first('description') }}</small>
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
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.config.autoParagraph = false;
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
CKEDITOR.replace( 'description' );
</script>
@endsection
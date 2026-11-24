@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>News And Events</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('news-event.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                  <div class="card-header">
                    <h4>Create News And Events</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Type <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" required>
                          <option value="" selected>Choose Type</option>
                          @foreach(Config::get('enum.news_event_type') as $key => $value)
                          <option value="{{$value}}" @if(old('type') == $value) selected @endif>{{$key}}</option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('type') }}</small>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="title" value="{{old('title')}}" required class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('title') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" name="date" value="{{old('date')}}" required class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('date') }}</small>
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
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="image" accept="image/*" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" required>
                        <span class="form-text">image size : 800 * 560px</span>
                        <small class="text-danger">{{ $errors->first('image') }}</small>
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
<script>CKEDITOR.replace( 'description' );</script>
@endsection
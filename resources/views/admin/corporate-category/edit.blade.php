@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Corporate Category</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('corporate-category.update',$category->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}

                  <div class="card-header">
                    <h4>Edit Corporate Category</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Type <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" required>
                          <option value="Corporate Course" selected>Corporate Course</option>
                          {{-- @foreach(Config::get('enum.type') as $key => $value)
                          <option value="{{$value}}" @if(old('type') == $value) selected @elseif($category->type == $value) selected @endif>{{$key}}</option>
                          @endforeach --}}
                        </select>
                        <small class="text-danger">{{ $errors->first('type') }}</small>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="category_name" value="{{$category->category_name}}" required class="form-control {{ $errors->has('category_name') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('category_name') }}</small>
                      </div>
                    </div>
               
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category Description <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('category_description') ? ' is-invalid' : '' }}" name="category_description" required id="category_description">{!! $category->description !!}</textarea>
                        <small class="text-danger">{{ $errors->first('category_description') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cover Image <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <br>
                        <img src= "/storage/{{ $category->cover_image }}" style="width:150px;height:150px /"> 
                        <input type="file" name="cover_image" value="{{$category->cover_image}}" accept="image/*" class="form-control {{ $errors->has('cover_image') ? ' is-invalid' : '' }}">
                        <span class="form-text">image size : 500 * 300px</span>
                        <small class="text-danger">{{ $errors->first('cover_image') }}</small>
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
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace( 'category_description' );</script>
@endsection
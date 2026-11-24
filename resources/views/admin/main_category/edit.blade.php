@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header"><h1>Main Category</h1></div>
    <div class="row"><div class="col-12"><div class="card">
      <form method="POST" action="{{route('m-category.update', $category->id)}}" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <div class="card-header"><h4>Edit Category</h4></div>
        <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Type <span class="text-danger">*</span></label>
            <div class="col-sm-12 col-md-7">
              <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" required>
                @foreach(Config::get('enum.type') as $key => $value)
                  <option value="{{$value}}" {{ (old('type') ?? $category->type) == $value ? 'selected' : '' }}>{{$key}}</option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('type') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category Name <span class="text-danger">*</span></label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="category_name" value="{{$category->category_name}}" required class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}">
              <small class="text-danger">{{ $errors->first('category_name') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description <span class="text-danger">*</span></label>
            <div class="col-sm-12 col-md-7">
              <textarea class="form-control {{ $errors->has('category_description') ? 'is-invalid' : '' }}" name="category_description" id="category_description" required>{!! $category->description !!}</textarea>
              <small class="text-danger">{{ $errors->first('category_description') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cover Image</label>
            <div class="col-sm-12 col-md-7">
              @if($category->cover_image)
                <img src="/storage/{{$category->cover_image}}" style="width:150px;height:100px;object-fit:cover;" class="mb-2 d-block">
              @endif
              <input type="file" name="cover_image" accept="image/*" class="form-control {{ $errors->has('cover_image') ? 'is-invalid' : '' }}">
              <small class="text-muted">Leave blank to keep current image</small>
              <small class="text-danger">{{ $errors->first('cover_image') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Enable Status</label>
            <div class="col-sm-12 col-md-7">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="enable_status" value="1" {{ ($category->status ?? 1) == 1 ? 'checked' : '' }}>
                <label class="form-check-label">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="enable_status" value="0" {{ ($category->status ?? 1) == 0 ? 'checked' : '' }}>
                <label class="form-check-label">No</label>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary">Update</button>
              <a href="{{route('m-category.index')}}" class="btn btn-secondary ml-2">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div></div></div>
  </section>
</div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('category_description');</script>
@endsection

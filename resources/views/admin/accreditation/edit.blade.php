@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Accreditations</h1>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form method="POST" action="{{route('accreditation.update', $accreditation->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="card-header">
              <h4>Edit Accreditation</h4>
            </div>
            <div class="card-body">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title <span class="text-danger">*</span></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="title" value="{{$accreditation->title}}" required class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                  <small class="text-danger">{{ $errors->first('title') }}</small>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image</label>
                <div class="col-sm-12 col-md-7">
                  @if($accreditation->image)
                    <img src="/storage/{{$accreditation->image}}" style="width:150px;height:150px;object-fit:cover;" class="mb-2 d-block">
                  @endif
                  <input type="file" name="image" accept="image/*" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                  <small class="text-muted">Leave blank to keep current image</small>
                  <small class="text-danger">{{ $errors->first('image') }}</small>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button class="btn btn-primary">Update</button>
                  <a href="{{route('accreditation.index')}}" class="btn btn-secondary ml-2">Cancel</a>
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

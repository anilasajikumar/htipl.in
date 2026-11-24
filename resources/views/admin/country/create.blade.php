@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header"><h1>Country</h1></div>
    <div class="row"><div class="col-12"><div class="card">
      <form method="POST" action="{{route('country.store')}}">
        @csrf
        <div class="card-header"><h4>Create Country</h4></div>
        <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Country <span class="text-danger">*</span></label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="country" value="{{old('country')}}" required class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}">
              <small class="text-danger">{{ $errors->first('country') }}</small>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary">Submit</button>
              <a href="{{route('country.index')}}" class="btn btn-secondary ml-2">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div></div></div>
  </section>
</div>
@endsection

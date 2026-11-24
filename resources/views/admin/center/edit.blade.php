@extends('layouts.admin.layout')
@section('content')
  
  <div class="main-content">
  <section class="section">
  <div class="section-header">
  <h1>Study Center</h1>
  </div>
  <div class="row">
  <div class="col-12">
  <div class="card">
  <form method="POST" action="{{route('center.update',$center->id)}}" enctype="multipart/form-data">
  {{csrf_field()}}
  {{method_field('PATCH')}}
  <div class="card-header">
  <h4>Edit Study Center</h4>
  </div>

  <div class="card-body">
  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center Name <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <input type="text" name="study_center_name" required value="{{$center->study_center_name}}" class="form-control {{ $errors->has('study_center_name') ? ' is-invalid' : '' }}">
  <small class="text-danger">{{ $errors->first('study_center_name') }}</small>
  </div>
  </div>

  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center Contact Person <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <input type="text" name="study_center_contact_person" required value="{{$center->study_center_contact_person}}" class="form-control {{ $errors->has('study_center_contact_person') ? ' is-invalid' : '' }}">
  <small class="text-danger">{{ $errors->first('study_center_contact_person') }}</small>
  </div>
  </div>

  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center Email <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <input type="email" name="study_center_email" required value="{{$center->study_center_email}}" class="form-control {{ $errors->has('study_center_email') ? ' is-invalid' : '' }}">
  <small class="text-danger">{{ $errors->first('study_center_email') }}</small>
  </div>
  </div>

  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center Mobile <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <input type="number" name="study_center_mobile" required value="{{$center->study_center_mobile}}" class="form-control {{ $errors->has('study_center_mobile') ? ' is-invalid' : '' }}">
  <small class="text-danger">{{ $errors->first('study_center_mobile') }}</small>
  </div>
  </div>

  
  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center Address <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <textarea name="study_center_address" required value="{{$center->study_center_address}}" class="form-control {{ $errors->has('study_center_address') ? ' is-invalid' : '' }}" rows="100">{{$center->study_center_address}}</textarea>
  <small class="text-danger">{{ $errors->first('study_center_address') }}</small>
  </div>
  </div>

  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Zip/Pin Code <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <input type="number" name="pincode" required min="0" value="{{$center->pincode}}" class="form-control {{ $errors->has('pincode') ? ' is-invalid' : '' }}">
  <small class="text-danger">{{ $errors->first('pincode') }}</small>
  </div>
  </div>

  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Location <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <select name="location" required class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }} selectric">
  @foreach($location as $key => $value)
  <option value="{{$value}}" @if($center->location_id == $value) selected @endif>{{$key}}</option>
  @endforeach
  </select>
  <small class="text-danger">{{ $errors->first('location') }}</small>
  </div>
  </div>


  <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo <span class="text-danger">*</span></label>
  <div class="col-sm-12 col-md-7">
  <br>
  <img src= "/storage/{{ $center->logo }}" style="width:150px;height:150px /"> 
  <input type="file" name="logo" value="{{$center->logo}}" class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}">
  <span class="form-text">image size : 500 * 300px</span>
  <small class="text-danger">{{ $errors->first('logo') }}</small>
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
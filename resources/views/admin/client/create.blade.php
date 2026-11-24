@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Clients</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('client.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                  <div class="card-header">
                    <h4>Create Clients</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="name" value="{{old('name')}}" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="logo" accept="image/*" class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}" required>
                        <span class="form-text">logo size : 400 * 400px</span>
                        <small class="text-danger">{{ $errors->first('logo') }}</small>
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
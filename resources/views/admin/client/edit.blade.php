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
                  <form method="POST" action="{{route('client.update',$client->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                  <div class="card-header">
                    <h4>Edit Clients</h4>
                  </div>

                  <div class="card-body">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="name" value="{{$client->name}}" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <br>
                        <img src= "/storage/{{ $client->logo }}" style="width:150px;height:150px /"> 
                        <input type="file" name="logo" accept="image/*" class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}">
                        <span class="form-text">logo size : 800 * 560px</span>
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
@section('script')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace( 'description' );</script>
@endsection
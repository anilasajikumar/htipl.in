@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Change Trainor Password</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <h5 class="mb-3">{{ $trainor->name }}</h5>
    <form method="POST" action="{{ route('trainor.update-password', $trainor->id) }}">
      @csrf @method('PATCH')
      <div class="form-group">
        <label>New Password <span class="text-danger">*</span></label>
        <input type="password" name="password" required class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('password') }}</small>
      </div>
      <div class="form-group">
        <label>Confirm Password <span class="text-danger">*</span></label>
        <input type="password" name="password_confirmation" required class="form-control">
      </div>
      <button class="btn btn-primary">Update Password</button>
      <a href="{{ route('trainor.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
@endsection

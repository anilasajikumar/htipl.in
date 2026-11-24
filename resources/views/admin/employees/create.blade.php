@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Create Employee</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <form method="POST" action="{{ route('employees.store') }}">
      @csrf
      <div class="form-group">
        <label>Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('name') }}</small>
      </div>
      <div class="form-group">
        <label>Email <span class="text-danger">*</span></label>
        <input type="email" name="email" value="{{ old('email') }}" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('email') }}</small>
      </div>
      <div class="form-group">
        <label>Password <span class="text-danger">*</span></label>
        <input type="password" name="password" required class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('password') }}</small>
      </div>
      <button class="btn btn-primary">Create Employee</button>
      <a href="{{ route('employees.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
@endsection

@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Create Batch</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <form method="POST" action="{{ route('batch.store') }}">
      @csrf
      <div class="form-group">
        <label>Title <span class="text-danger">*</span></label>
        <input type="text" name="title" value="{{ old('title') }}" required class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('title') }}</small>
      </div>
      <button class="btn btn-primary">Submit</button>
      <a href="{{ route('batch.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
@endsection

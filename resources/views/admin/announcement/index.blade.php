@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Announcement Settings</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('announcement.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Announcement Text <span class="text-danger">*</span></label>
        <input type="text" name="text" class="form-control" value="{{ old('text', $announcement->text ?? '') }}" required>
      </div>
      <div class="form-group">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="statusSwitch" name="status" value="1"
            {{ isset($announcement) && $announcement->status ? 'checked' : '' }}>
          <label class="custom-control-label" for="statusSwitch">Enable Announcement</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div></div>
</div></section>
@endsection

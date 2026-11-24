@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Edit Trainor</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <form method="POST" action="{{ route('trainor.update', $trainor->id) }}">
      @csrf @method('PATCH')
      <div class="form-group">
        <label>Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $trainor->name) }}" required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('name') }}</small>
      </div>
      <div class="form-group">
        <label>Email <span class="text-danger">*</span></label>
        <input type="email" name="email" value="{{ old('email', $trainor->email) }}" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('email') }}</small>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $trainor->phone) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Batch</label>
        <select name="batch_id" class="form-control">
          <option value="">-- No Batch --</option>
          @foreach($batches as $batch)
            <option value="{{ $batch->id }}" {{ (old('batch_id', $trainor->batch_id) == $batch->id) ? 'selected' : '' }}>{{ $batch->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Expertise</label>
        <input type="text" name="expertise" value="{{ old('expertise', $trainor->expertise) }}" class="form-control">
      </div>
      <button class="btn btn-primary">Update</button>
      <a href="{{ route('trainor.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
@endsection

@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Edit Enquiry Form</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card">
    <form action="{{ route('enquiry-form.update', $enquiry_form->id) }}" method="POST">
      @csrf @method('PATCH')
      <div class="card-header"><h4>Edit Enquiry Form</h4></div>
      <div class="card-body">
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Name <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <input type="text" name="name" value="{{ old('name', $enquiry_form->name) }}" required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Email <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <input type="email" name="email" value="{{ old('email', $enquiry_form->email) }}" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
            <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Contact Number <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <input type="text" name="contact_number" value="{{ old('contact_number', $enquiry_form->contact_number) }}" required class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}">
            <small class="text-danger">{{ $errors->first('contact_number') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Date of Birth <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <input type="date" name="dob" value="{{ old('dob', $enquiry_form->dob) }}" required class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}">
            <small class="text-danger">{{ $errors->first('dob') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Gender</label>
          <div class="col-md-7">
            <select name="gender" class="form-control">
              <option value="">-- Select Gender --</option>
              @foreach(['Male','Female','Other'] as $g)
                <option value="{{ $g }}" {{ (old('gender', $enquiry_form->gender) == $g) ? 'selected' : '' }}>{{ $g }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Address</label>
          <div class="col-md-7">
            <textarea name="address" rows="3" class="form-control">{{ old('address', $enquiry_form->address) }}</textarea>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Centre <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <select name="center" required class="form-control {{ $errors->has('center') ? 'is-invalid' : '' }}">
              <option value="">-- Choose Center --</option>
              @foreach($centers as $name => $id)
                <option value="{{ $id }}" {{ (old('center', $enquiry_form->center) == $id) ? 'selected' : '' }}>{{ $name }}</option>
              @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('center') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Course <span class="text-danger">*</span></label>
          <div class="col-md-7">
            @php $selectedCourses = json_decode($enquiry_form->course, true) ?? []; @endphp
            <select name="course[]" required multiple class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}" style="min-height:120px">
              @foreach($course as $name => $id)
                <option value="{{ $id }}" {{ in_array($id, old('course', $selectedCourses)) ? 'selected' : '' }}>{{ $name }}</option>
              @endforeach
            </select>
            <small class="text-muted">Hold Ctrl to select multiple.</small>
            <small class="text-danger d-block">{{ $errors->first('course') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Message <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <textarea name="message" required class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}">{{ old('message', $enquiry_form->message) }}</textarea>
            <small class="text-danger">{{ $errors->first('message') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3 col-form-label text-md-right">Enquiry Date <span class="text-danger">*</span></label>
          <div class="col-md-7">
            <input type="date" name="enquiry_date" value="{{ old('enquiry_date', $enquiry_form->enquiry_date) }}" required class="form-control {{ $errors->has('enquiry_date') ? 'is-invalid' : '' }}">
            <small class="text-danger">{{ $errors->first('enquiry_date') }}</small>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-md-3"></label>
          <div class="col-md-7">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('enquiry-form.index') }}" class="btn btn-secondary ml-2">Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div></section>
@endsection

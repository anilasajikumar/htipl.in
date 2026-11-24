@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Invoice Account Settings</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  <div class="row"><div class="col-md-8 col-lg-6">
    <div class="card">
      <form method="POST" action="{{ route('invoice.account.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label>Account Name</label>
            <input name="account_name" class="form-control" value="{{ $setting->account_name ?? '' }}">
          </div>
          <div class="form-group">
            <label>Account Number</label>
            <input name="account_number" class="form-control" value="{{ $setting->account_number ?? '' }}">
          </div>
          <div class="form-group">
            <label>Bank Name</label>
            <input name="bank_name" class="form-control" value="{{ $setting->bank_name ?? '' }}">
          </div>
          <div class="form-group">
            <label>IFSC Code</label>
            <input name="ifsc_code" class="form-control" value="{{ $setting->ifsc_code ?? '' }}">
          </div>
          <div class="form-group">
            <label>Branch</label>
            <input name="branch" class="form-control" value="{{ $setting->branch ?? '' }}">
          </div>
          <div class="form-group">
            <label>QR Code Image</label>
            <input type="file" name="qr_image" class="form-control-file">
            @if(!empty($setting->qr_image))
              <div class="mt-2"><img src="{{ asset($setting->qr_image) }}" width="120"></div>
            @endif
          </div>
        </div>
        <div class="card-footer text-right">
          <button class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div></div>
</div></section>
@endsection

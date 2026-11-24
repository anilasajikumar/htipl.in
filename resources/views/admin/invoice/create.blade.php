@extends('layouts.admin.layout')

@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">{{ isset($invoice) ? 'Edit Invoice' : 'Create Invoice' }}</h1></div>
  <div class="col-sm-6"><div class="float-sm-right">
    <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-sm">Back</a>
  </div></div>
</div></div></div>

<section class="content"><div class="container-fluid">
  <div class="row"><div class="col-md-10 col-lg-8">
    <div class="card">
      <form method="POST" action="{{ isset($invoice) ? route('invoice.update', $invoice->id) : route('invoice.store') }}">
        @csrf
        @if(isset($invoice)) @method('PUT') @endif

        <div class="card-header"><h4 class="card-title">Invoice Details</h4></div>
        <div class="card-body">

          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif

          {{-- STUDENT INFO --}}
          @if(isset($student))
          <input type="hidden" name="student_course_id" value="{{ $student->id }}">
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Student / Course</label>
            <div class="col-md-7">
              <input class="form-control" value="{{ $student->register_number }} - {{ $student->name }}{{ isset($student->course_name) ? ' ('.$student->course_name.')' : '' }}" readonly>
            </div>
          </div>
          @endif

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Invoice Number</label>
            <div class="col-md-7">
              <input type="text" name="invoice_number" class="form-control" value="{{ $invoice->invoice_number ?? '' }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Invoice Date <span class="text-danger">*</span></label>
            <div class="col-md-7">
              <input type="date" name="invoice_date" class="form-control" value="{{ $invoice->invoice_date ?? '' }}" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Sub Total <span class="text-danger">*</span></label>
            <div class="col-md-7">
              <input type="number" step="0.01" name="sub_total" class="form-control amount" value="{{ $invoice->sub_total ?? '' }}" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Discount</label>
            <div class="col-md-7">
              <input type="number" step="0.01" name="discount" class="form-control amount" value="{{ $invoice->discount ?? 0 }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Tax</label>
            <div class="col-md-7">
              <input type="number" step="0.01" name="tax" class="form-control amount" value="{{ $invoice->tax ?? 0 }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Total Amount</label>
            <div class="col-md-7">
              <input type="number" step="0.01" name="total_amount" class="form-control" value="{{ $invoice->total_amount ?? '' }}" readonly required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Offer Name</label>
            <div class="col-md-7">
              <input type="text" name="offer_name" class="form-control" value="{{ $invoice->offer_name ?? '' }}">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label">Status</label>
            <div class="col-md-7">
              <select name="status" class="form-control">
                <option value="pending" {{ (isset($invoice) && $invoice->status=='pending') ? 'selected' : '' }}>Pending</option>
                <option value="partial" {{ (isset($invoice) && $invoice->status=='partial') ? 'selected' : '' }}>Partial</option>
                <option value="paid"    {{ (isset($invoice) && $invoice->status=='paid')    ? 'selected' : '' }}>Paid</option>
              </select>
            </div>
          </div>

          <hr>
          <h5>Installments</h5>

          <table class="table table-bordered" id="installmentTable">
            <thead>
              <tr>
                <th>Date</th><th>Amount</th><th>Paid</th><th width="80">Action</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($invoice) && $invoice->installments)
                @foreach($invoice->installments as $inst)
                <tr>
                  <td><input type="date" name="installments[date][]" class="form-control" value="{{ $inst->installment_date }}"></td>
                  <td><input type="number" step="0.01" name="installments[amount][]" class="form-control" value="{{ $inst->amount }}"></td>
                  <td>
                    <select name="installments[is_paid][]" class="form-control">
                      <option value="0" {{ $inst->is_paid==0 ? 'selected':'' }}>No</option>
                      <option value="1" {{ $inst->is_paid==1 ? 'selected':'' }}>Yes</option>
                    </select>
                  </td>
                  <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                </tr>
                @endforeach
              @endif
            </tbody>
          </table>

          <button type="button" id="addInstallment" class="btn btn-success btn-sm mb-3">+ Add Installment</button>

        </div>
        <div class="card-footer text-right">
          <button class="btn btn-primary">{{ isset($invoice) ? 'Update Invoice' : 'Create Invoice' }}</button>
        </div>
      </form>
    </div>
  </div></div>
</div></section>
@endsection

@section('script')
<script>
$(function() {
  $('.amount').on('input', function() {
    let sub      = parseFloat($('input[name="sub_total"]').val()) || 0;
    let discount = parseFloat($('input[name="discount"]').val()) || 0;
    let tax      = parseFloat($('input[name="tax"]').val()) || 0;
    $('input[name="total_amount"]').val((sub - discount + tax).toFixed(2));
  });

  $('#addInstallment').click(function() {
    $('#installmentTable tbody').append(`
      <tr>
        <td><input type="date" name="installments[date][]" class="form-control"></td>
        <td><input type="number" step="0.01" name="installments[amount][]" class="form-control"></td>
        <td>
          <select name="installments[is_paid][]" class="form-control">
            <option value="0">No</option><option value="1">Yes</option>
          </select>
        </td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
      </tr>`);
  });

  $(document).on('click', '.removeRow', function() {
    $(this).closest('tr').remove();
  });
});
</script>
@endsection

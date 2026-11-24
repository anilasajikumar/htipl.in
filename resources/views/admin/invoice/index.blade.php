@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{ asset('/admin_dashboard/assets/css/jquery.dataTables.min.css') }}">
@endsection
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Student Invoice List</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  <div class="card"><div class="card-body">
    <div class="row mb-3">
      <div class="col-md-3">
        <select id="month" class="form-control">
          <option value="">Select Month</option>
          @for($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}">{{ date('F', mktime(0,0,0,$m,1)) }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3">
        <select id="year" class="form-control">
          <option value="">Select Year</option>
          @for($y = date('Y'); $y >= 2020; $y--)
            <option value="{{ $y }}">{{ $y }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button id="filter" class="btn btn-primary mr-2">Search</button>
        <a id="exportBtn" class="btn btn-warning">Export CSV</a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table cell-border hover stripe" id="student-invoice-table">
        <thead>
          <tr>
            <th>Reg No</th><th>Name</th><th>Email</th><th>Mobile</th>
            <th>Invoice Date</th><th>Total Amount</th><th>Status</th><th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div></div>
</div></section>
@endsection

@section('script')
<script src="{{ asset('/admin_dashboard/assets/js/jquery.dataTables.min.js') }}"></script>
<script>
$(function() {
    let table = $('#student-invoice-table').DataTable({
        processing: true, serverSide: true,
        ajax: {
            url: "{{ route('invoice.data') }}",
            data: function(d) {
                d.month = $('#month').val();
                d.year  = $('#year').val();
            }
        },
        columns: [
            { data: 'register_number', name: 'student_courses.register_number' },
            { data: 'name', name: 'student_courses.name' },
            { data: 'email', name: 'student_courses.email' },
            { data: 'mobile', name: 'student_courses.mobile' },
            { data: 'invoice_date', name: 'invoices.invoice_date' },
            { data: 'total_amount', name: 'invoices.total_amount' },
            { data: 'status', name: 'invoices.status' },
            { data: 'invoice_action', orderable: false, searchable: false }
        ]
    });
    $('#filter').click(function() { table.draw(); });
    $('#exportBtn').click(function() {
        window.location = "{{ route('invoice.export') }}?month=" + $('#month').val() + "&year=" + $('#year').val();
    });
});
</script>
@endsection

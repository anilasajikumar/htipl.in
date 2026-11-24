@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Enquiry Forms</h1></div>
  <div class="col-sm-6 text-right">
    <a href="{{ route('enquiry-form.create') }}" class="btn btn-primary">Add New</a>
  </div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <form action="{{ route('postdata') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
          <div class="col-md-3">
            <select name="year" class="form-control">
              <option value="" disabled selected>-- Select Year --</option>
              @foreach($years as $availableYear)
                <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>{{ $availableYear }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-7">
            <select name="month" id="month" class="form-control">
              @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $i => $m)
                <option value="{{ $i+1 }}" {{ $month == $i+1 ? 'selected' : '' }}>{{ $m }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table cell-border hover stripe" id="enquiryform-table">
          <thead>
            <tr>
              <th>NAME</th><th>EMAIL</th><th>CONTACT</th><th>COURSE</th><th>CENTER</th>
              <th>MESSAGE</th><th>DOB</th><th>DATE</th><th>EDIT</th><th>DELETE</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div></section>
<form id="edit-form" method="POST" action="">@csrf {{ method_field('DELETE') }}</form>
@endsection

@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>
$(function() {
    var month = $('#month').val();
    var year  = $('select[name=year]').val();
    var table = $('#enquiryform-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: {
            url: '{!! route('enquiry_form_data') !!}',
            type: 'GET',
            data: function(d) {
                d.month = $('#month').val();
                d.year  = $('select[name=year]').val();
            }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'contact_number', name: 'contact_number' },
            { data: 'course_name', name: 'course_name' },
            { data: 'center_name', name: 'center_name' },
            { data: 'message', name: 'message' },
            { data: 'dob', name: 'dob' },
            { data: 'enquiryDate', name: 'enquiryDate' },
            { data: 'edit', name: 'edit', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>B",
        buttons: [{ extend: 'excelHtml5', title: 'Enquiry Form Data' }]
    });
    $('body').on('click', '.deteting-btn', function(e) {
        e.preventDefault();
        if (confirm("Do You Want To Delete?")) {
            $("#edit-form").attr('action', $(this).data('url')).submit();
        }
    });
});
</script>
@endsection

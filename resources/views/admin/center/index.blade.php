@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Study Center</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class='text-left'><a href="{{route('center.create')}}"><button class='btn w3-btn btn-success'>Add</button></a></div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="center-table">
  <thead class=" text-primary">
  <th>
   CENTER ID
  </th>
  <th>
   CENTER NAME
  </th>
    <th>
CONTACT PERSON
  </th>
  <th>
EMAIL
  </th>
  <th>
MOBILE
  </th>
  <th>
ADDRESS
  </th>
  <th>
LOCATION
  </th>
  <th>
ACTION                      
  </th>
  <th>
UPDATE                      
  </th>
  <th>
DELETE                     
  </th>
        
  </thead>
</table>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
</section>
</div>

<form id="edit-form" method="POST" action="">
@csrf
{{ method_field('DELETE') }}
</form>
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#center-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('center_data') !!}',
        columns: [
            { data: 'study_center_id', name: 'study_center_id' },
            { data: 'study_center_name', name: 'study_center_name' },
            { data: 'study_center_contact_person', name: 'study_center_contact_person' },
            { data: 'study_center_email', name: 'study_center_email' },
            { data: 'study_center_mobile', name: 'study_center_mobile' },
            { data: 'study_center_address', name: 'study_center_address' },
            // { data: 'pincode', name: 'pincode' },
            { data: 'location', name: 'location' },
            // { data: 'logo', name: 'logo' ,
            //  render: function( data, type, full, meta ) {
            //             return "<img src=\"/storage/" + data + "\" height=\"50\"/>";
            //         }
            //     },
            { data: 'change-password', name: 'change-password', orderable: false, searchable: false },
            { data: 'edit', name: 'edit', orderable: false, searchable: false},
            { data: 'action', name: 'action', orderable: false, searchable: false}
          
        ]
    });
    $('body').on('click','.deteting-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Delete?")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endsection

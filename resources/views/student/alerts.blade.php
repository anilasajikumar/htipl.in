@extends('layouts.student.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Alerts</h1>
    </div>
    <div class="content-wrapper">
<div class="row">
  <div class="col-md-12">
  <div class="card">
      <div class="card-body">
      <div class="table-responsive">
      <table class="table cell-border hover stripe " id="alerts_table">
        <thead class=" text-primary">
          <tr>
            <th>
            DATE                      
              </th>
            <th>
            TITLE                      
              </th>
              <th>
            MESSAGE                     
              </th>
          </tr>
        </thead>
        <tbody>
          @foreach($alerts as $alert)
          <tr>
            <td> {{ Carbon\Carbon::parse($alert->updated_at)->format('d-m-Y') }}</td>
            <td> {{ $alert->title }}</td>
            <td> {{ $alert->message }}</td>
          </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>
</div>
</div>
</section>
</div>

@endsection
@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
  $(function() {
    $('#alerts_table').DataTable();
  });
</script>
@endsection
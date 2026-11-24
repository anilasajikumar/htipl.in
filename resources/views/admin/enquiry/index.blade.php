@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
  <h1>Enquiry Forms</h1>
</div>

<form method="GET">
<div class="row mb-3">
  <div class="col-md-2">
    <select name="year" class="form-control">
      @foreach($years as $y)
        <option value="{{ $y }}" {{ $year==$y?'selected':'' }}>{{ $y }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3">
    <select name="month" class="form-control">
      @for($m=1;$m<=12;$m++)
        <option value="{{ $m }}" {{ $month==$m?'selected':'' }}>
          {{ date('F', mktime(0,0,0,$m,1)) }}
        </option>
      @endfor
    </select>
  </div>

  <div class="col-md-3">
    <input type="text" name="search" class="form-control"
           placeholder="Search name / email / phone"
           value="{{ $search }}">
  </div>

  <div class="col-md-2">
    <button class="btn btn-primary w-100">Filter</button>
  </div>

  <div class="col-md-2">
    <a href="{{ route('enquiry.export',['year'=>$year,'month'=>$month]) }}"
       class="btn btn-success w-100">
       Download Excel
    </a>
  </div>
</div>
</form>

<div class="card">
<div class="card-body table-responsive">
<table class="table table-bordered">
<thead>
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Contact</th>
  <th>Course</th>
  <th>Center</th>
  <th>Message</th>
  <th>DOB</th>
  <th>Date</th>
  <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($enquiries as $e)
<tr>
  <td>{{ $e->name }}</td>
  <td>{{ $e->email }}</td>
  <td>{{ $e->contact_number }}</td>
  <td>{{ $e->course->course_name ?? '' }}</td>
  <td>{{ $e->center->study_center_name ?? '' }}</td>
  <td>{{ $e->message }}</td>
  <td>{{ $e->dob }}</td>
  <td>{{ $e->created_at->format('d-m-Y') }}</td>
  <td>
    <form method="POST" action="{{ route('enquiry.destroy',$e->id) }}">
      @csrf @method('DELETE')
      <button class="btn btn-danger btn-sm"
              onclick="return confirm('Delete?')">
        Delete
      </button>
    </form>
  </td>
</tr>
@endforeach
</tbody>
</table>

{{ $enquiries->links() }}

</div>
</div>
</section>
</div>
@endsection

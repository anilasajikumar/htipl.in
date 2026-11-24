@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Trainors</h1></div>
  <div class="col-sm-6 text-right">
    <a href="{{ route('trainor.create') }}" class="btn btn-primary">Add Trainor</a>
    <a href="{{ route('assessment.create') }}" class="btn btn-success ml-2">Create Assessment</a>
  </div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body table-responsive p-0">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <table class="table table-hover">
      <thead>
        <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Batch</th><th>Expertise</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($trainors as $i => $trainor)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $trainor->name }}</td>
          <td>{{ $trainor->email }}</td>
          <td>{{ $trainor->phone ?? '-' }}</td>
          <td>{{ $trainor->batch->title ?? '-' }}</td>
          <td>{{ $trainor->expertise ?? '-' }}</td>
          <td>
            <a href="{{ route('trainor.toggle-status', $trainor->id) }}" class="badge badge-{{ $trainor->status ? 'success' : 'secondary' }}">
              {{ $trainor->status ? 'Active' : 'Inactive' }}
            </a>
          </td>
          <td>
            <a href="{{ route('trainor.edit', $trainor->id) }}" class="btn btn-sm btn-info">Edit</a>
            <a href="{{ route('trainor.edit-password', $trainor->id) }}" class="btn btn-sm btn-warning">Password</a>
            <form action="{{ route('trainor.destroy', $trainor->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center">No trainors found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div></div>
</div></section>
@endsection

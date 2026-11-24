@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Employees</h1></div>
  <div class="col-sm-6 text-right"><a href="{{ route('employees.create') }}" class="btn btn-primary">+ Create Employee</a></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  <div class="card"><div class="card-body table-responsive p-0">
    <table class="table table-bordered table-striped">
      <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($employees as $i => $emp)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $emp->first_name }}</td>
          <td>{{ $emp->email }}</td>
          <td>
            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#passwordModal" onclick="document.getElementById('user_id').value={{ $emp->id }}">
              Change Password
            </button>
            <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this employee?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No employees found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div></div>
</div></section>

<div class="modal fade" id="passwordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('employees.updatePassword') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Change Employee Password</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="user_id">
          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

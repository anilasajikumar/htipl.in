@extends('layouts.admin.layout')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Footer Records</h1></div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('footer.create') }}" class="btn btn-primary">Add New</a>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover">
          <thead>
            <tr><th>#</th><th>Name</th><th>Phone</th><th>Action</th></tr>
          </thead>
          <tbody>
            @forelse($records as $key => $record)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $record->name }}</td>
              <td>{{ $record->phone }}</td>
              <td>
                <a href="{{ route('footer.edit', $record->id) }}" class="btn btn-sm btn-info">Edit</a>
                <form action="{{ route('footer.destroy', $record->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this record?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No records found.</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="p-3">{{ $records->links() }}</div>
      </div>
    </div>
  </div>
</section>
@endsection

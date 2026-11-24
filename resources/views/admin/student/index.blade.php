@extends('layouts.admin.layout')
@section('content')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (for dismissing toasts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add jQuery & Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        {{ session('success') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif


<div class="main-content">
    <section class="section">
       <div class="section-header d-flex justify-content-between align-items-center">
    <h1 class="mb-0">Registered Students</h1>
    <a href="{{ route('student.create') }}" class="btn btn-primary ms-3">
        <i class="fas fa-plus"></i> Create Student
    </a>
</div>

        <div class="row">
            <div class="col-12">
                <div class="card" style="max-width: 1900px;">
                    <div class="card-body table-responsive">
            <form method="GET" action="{{ route('student.ajaxSearch') }}" class="mb-4">
    <div class="row">
        <div class="col-md-6">
            <input type="text" name="search" id="student-search" class="form-control" placeholder="Enter name, email, or register number" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
                        <table class="table table-bordered table-striped" id="student-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Course Name</th>
                                    <th>Register No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->student_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>{{ $item->course_name }}</td>
                                        <td>{{ $item->register_number }}</td>
                                           <td>
                                            <a href="{{ route('student.registeredit', $item->id) }}" class="btn btn-info btn-sm me-1">Edit</a>

  <form action="{{ url('dashboard/students/' . $item->id . '/delete') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?')">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm me-1">Delete</button>
</form>


                                            <form action="{{ route('student.certificatecomplete', $item->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-success btn-sm me-1">Completed</button>
                                            </form>

                                            

                                        </td>
                                    </tr>
                                @endforeach
                                @if($registrations->isEmpty())
                                    <tr><td colspan="6" class="text-center">No data found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        <nav>
    <ul class="pagination justify-content-center" id="pagination"></ul>
</nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    const toastEl = document.querySelector('#successToast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
    }
</script>

<script>
$(document).ready(function() {
    $('#student-search').select2({
        placeholder: 'Search student by name, email, or register number',
        ajax: {
            url: '{{ route("student.ajaxSearch") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: `${item.student_name} - ${item.register_number}`
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPage = 10;
    const table = document.getElementById('student-table');
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    const pagination = document.getElementById('pagination');
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    function displayRows(startIndex) {
        rows.forEach((row, index) => {
            row.style.display = (index >= startIndex && index < startIndex + rowsPerPage) ? '' : 'none';
        });
    }

    function setupPagination() {
        pagination.innerHTML = '';

        for (let i = 0; i < totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item';
            li.innerHTML = `<a class="page-link" href="#">${i + 1}</a>`;
            li.addEventListener('click', function (e) {
                e.preventDefault();
                displayRows(i * rowsPerPage);

                document.querySelectorAll('#pagination li').forEach(li => li.classList.remove('active'));
                li.classList.add('active');
            });

            pagination.appendChild(li);
        }

        // Default: show first page
        pagination.firstChild.classList.add('active');
        displayRows(0);
    }

    setupPagination();
});
</script>

@endsection

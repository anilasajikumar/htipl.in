@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>COURSE EXAMS</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="course-exam-table">
  <thead class=" text-primary">
  <th>
   COURSE
  </th>
  <th>
   EXAM NAME
  </th>
  <th>
   TOTAL QUESTIONS
  </th>
  <th>
   MARK PER QUESTIONS
  </th>
  <th>
   MINUS MARK PER QUESTIONS
  </th>
  <th>
   TOTAL MARKS
  </th>
  <th>
   TOTAL TIME
 </th>
  <th>
ACTION                      
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

<form id="edit-form" method="get" action="">
@csrf
</form>
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#course-exam-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('course-exam.trash.data') !!}',
        columns: [
            { data: 'course_name', name: 'course_name' },
            { data: 'exam_name', name: 'exam_name' },
            { data: 'total_questions', name: 'total_questions' },
            { data: 'mark_per_question', name: 'mark_per_question' },
            { data: 'minus_mark_per_question', name: 'minus_mark_per_question' },
            { data: 'total_marks', name: 'total_marks' },
            { data: 'total_time', name: 'total_time' },
            { data: 'restore', name: 'restore', orderable: false, searchable: false}
          
        ]
    });
    $('body').on('click','.deteting-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Restore?")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endsection

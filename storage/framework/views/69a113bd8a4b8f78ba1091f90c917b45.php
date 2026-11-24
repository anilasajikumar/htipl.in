<?php $__env->startSection('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')); ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Students</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
       <div class="col-md-12">
          <div class="card">
            <div class="card-body">

             <?php if(count($errors)>0): ?>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="alert alert-danger">
                <p><?php echo e($error); ?></p>
              </div>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
              <form method="get" action="<?php echo e(route('completed_students')); ?>">

                <div class="container-fluid bg-light ">
                  <div class="row align-items-center justify-content-center">


                   <div class="col-md-2 pt-3">
                     <div class="form-group ">
                       <label>Course</label>
                        <select name="course" id="course" class="form-control">
                          <option value="" selected>----Select----</option>
                        <?php $__currentLoopData = $course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($key); ?></option>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>
                    </div>


                    <div class="col-md-2 pt-3">
                      <div class="form-group ">
                        <label>Exam Date</label>
                        <input type="date" name="exam_date" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-2 pt-3">
                      <button type="submit" class="btn btn-danger btn-block">Search</button>
                    </div>

                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="completed-students-table">
  <thead class=" text-primary">
  <th>
COURSE NAME                      
  </th>
  <th>
REGISTER NUMBER                      
  </th>
    <th>
REG                     
  </th>
   <th>
EXAM DATE                      
  </th>
   <th>
NAME                   
  </th>
    <th>
GENDER                    
  </th>
    <th>
DOB                    
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
  IMAGE                    
  </th>
  <th>
  ID PROOF                    
  </th>
  <th>
CERTIFICATE                    
  </th>
        
  </thead>
  <tbody>
          <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td> <?php echo e($student->course_name); ?></td>
            <td> <?php echo e($student->register_number); ?></td>
                        <td> <?php echo e($student->st_reg_number); ?></td>
            
            <td> <?php echo e(Carbon\Carbon::parse($student->exam_date)->format('d-m-Y')); ?></td>
            <td> <?php echo e($student->name); ?></td>
            <td> <?php echo e($student->gender); ?></td>
            <td> <?php echo e(Carbon\Carbon::parse($student->dob)->format('d-m-Y')); ?></td>
            <td> <?php echo e($student->email); ?></td>
            <td> <?php echo e($student->mobile); ?></td>
            <td> <?php echo e($student->address); ?></td>
            <td><a href="<?php echo e(asset('/storage/'.$student->image)); ?>" download><button class="btn btn-success">Student Image</button></a></td>
            <td><a href="<?php echo e(asset('/storage/'.$student->id_proof)); ?>" download><button class="btn btn-warning">ID Proof Download</button></a></td>
            <td><a href="<?php echo e(route('students.certificate',$student->id)); ?>" class="btn btn-info btn-fw">Download</a></td>
       
          </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')); ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script>
$(function() {
   $('#completed-students-table').DataTable({
      dom: 'Bfrtip',
        buttons: [ {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                } } ]
                });
                /*
    $('#completed-students-table').DataTable({
      dom: 'Bfrtip',
        buttons: [ {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                } } ],
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '<?php echo route('completed_students_data'); ?>',
        columns: [
            { data: 'course_name', name: 'course_name' },
            { data: 'register_number', name: 'register_number' },
            { data: 'exam_date', name: 'exam_date' },
            { data: 'name', name: 'name' },
            { data: 'gender', name: 'gender' },
            { data: 'dob', name: 'dob' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'address', name: 'address' },
            { data: 'image', name: 'image' ,
             render: function( data, type, full, meta ) {
                        return "<img src=\"/storage/" + data + "\" height=\"50\"/>";
                    }
                },
            { data: 'id_proof', name: 'id_proof', orderable: false, searchable: false},
            { data: 'download', name: 'download', orderable: false, searchable: false}
        ],
        columnDefs:[
        {targets:2, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:5, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
    */
  });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.center.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/center/course/completed_students.blade.php ENDPATH**/ ?>
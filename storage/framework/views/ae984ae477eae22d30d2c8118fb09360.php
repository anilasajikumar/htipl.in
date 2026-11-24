<?php $__env->startSection('content'); ?>
<div class="container mt-5">
<h2>Course Calender</h2>
<table class="table table-bordered mt-4 mb-5">
  <thead style="background-color:  #fd7e14;">
    <tr class="text-white text-center">
      <th scope="col">COURSE NAME</th>
      <th scope="col">COURSE STARTING DATE</th>
      <th scope="col">LOCATION</th>
      <th scope="col">EXAM DATE</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="text-center">
      <td class="table-secondary"><?php echo e($data->course_name); ?></td>
      <td class="table-secondary"><?php echo e(\Carbon\Carbon::parse($data->starting_date)->format('j F Y')); ?></td>
      <td class="table-secondary"><?php echo e($data->location); ?></td>
      <td class="table-secondary">
        <?php echo e(\Carbon\Carbon::parse($data->exam_date)->format('j F Y')); ?> &nbsp; <br>
        <a style="text-decoration: none;" class="btn-sm btn-success mt-1" href="<?php echo e(route('apply_now.mail')); ?>">
          <small>Apply Now</small>
        </a>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/course_calendar.blade.php ENDPATH**/ ?>
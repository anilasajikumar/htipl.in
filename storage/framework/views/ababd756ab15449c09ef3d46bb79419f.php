<?php $__env->startSection('content'); ?>
<section class="qualifications_icrq">
     <div class="container">
          <h1 class="mb-5" data-aos="fade-up"><?php echo e($details->category_name); ?></h1>
          <!-- <h3 class="mb-2" data-aos="fade-up">courses</h3>
          <hr class="card-title-line" data-aos="fade-up"> -->

          <p><?php echo $details->description; ?></p>



<div class="list-group mt-5">
<?php $__currentLoopData = $details->OnlineCourse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($courses->slug != null): ?>
  <a href="<?php echo e(route('course_details',$courses->slug)); ?>" class="list-group-item list-group-item-action"><?php echo e($courses->course_name); ?></a>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $details->Exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($exam->slug != null): ?>
  <a href="<?php echo e(route('exam_details',$exam->slug)); ?>" class="list-group-item list-group-item-action"><?php echo e($exam->exam_name); ?></a>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


     </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/qualification_details.blade.php ENDPATH**/ ?>
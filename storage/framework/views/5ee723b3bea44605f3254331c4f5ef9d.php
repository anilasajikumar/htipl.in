<?php $__env->startSection('content'); ?>
 <!-- Navbar -->
<section class="qualifications_icrq">
     <div class="container">
          <h3 class="mb-2" data-aos="fade-up"><?php echo e($course->course_name); ?></h3>
          <hr class="card-title-line mb-5" data-aos="fade-up">
          <?php echo $course->course_description; ?>

          <?php if($course->pdf != null): ?>
          <a href="<?php echo e(route('course.download.broucher',$course->slug)); ?>" class="btn btn-large pull-right"><i class="icon-download-alt"> </i> Download Brochure </a>
          <?php endif; ?>
     </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/course_details.blade.php ENDPATH**/ ?>
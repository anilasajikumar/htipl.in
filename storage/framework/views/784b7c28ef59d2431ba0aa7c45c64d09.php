

<?php $__env->startSection('content'); ?>

<section class="Where-To-Study_icrq">
  <div class="container">

    <h2 class="mb-5" data-aos="fade-up">
      Our <span>Students Speak</span>
    </h2>

    <div class="row">

      <?php $__empty_1 = true; $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="col-md-12 mb-4" data-aos="fade-up">
        <div class="card mb-3">
          <div class="row no-gutters">

            <!-- VIDEO -->
            <div class="col-xl-8 col-lg-7 col-md-6">
              <div class="ratio ratio-16x9">
                <iframe 
  src="<?php echo e(str_replace('youtu.be/', 'www.youtube.com/embed/', $video->video_link)); ?>"
  frameborder="0"
  allowfullscreen>
</iframe>
              </div>
            </div>

            <!-- CONTENT -->
            <div class="col-xl-4 col-lg-5 col-md-6">
              <div class="card-body">
                <h5 class="card-title"><?php echo e($video->title); ?></h5>
                <hr class="card-title-line">

                <p class="card-text mt-3">
                  <?php echo e($video->description); ?>

                </p>

              </div>
            </div>

          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-md-12 text-center">
        <p>No video testimonials available.</p>
      </div>
      <?php endif; ?>

    </div>

  </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/video_testimonials.blade.php ENDPATH**/ ?>
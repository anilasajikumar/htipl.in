<?php $__env->startSection('content'); ?>
<section class="news-events-inner">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="mb-3" data-aos="fade-up"><?php echo e($news_event->title); ?></h2>
            <p>
              <img src="<?php echo e(asset('/storage/'.$news_event->image)); ?>" class="img-fluid" alt="Responsive image">
            </p>
          <p><?php echo e(Carbon\Carbon::parse($news_event->date)->format('d M Y')); ?></p>
            
            <p><?php echo $news_event->description; ?></p>
            </div>
          </div>
        </div>
      </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/news_events_inner.blade.php ENDPATH**/ ?>
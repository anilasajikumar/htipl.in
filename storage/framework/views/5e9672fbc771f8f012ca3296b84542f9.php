<?php $__env->startSection('content'); ?>
 <section class="about_icrq">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-2 ">
          <div class="col-md-12 text-left" data-aos="fade-up">
            <h2 class="mb-1">News & Events</h2>
          </div>
        </div>
        <div class="row">
        	<?php $__currentLoopData = $news_events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news_event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="blog-entry">
              <a href="<?php echo e(route('news-events.details',$news_event->slug)); ?>" data-aos="fade-up" class="block-20 d-flex align-items-end" style="background-image: url('<?php echo e(asset('/storage/'.$news_event->image)); ?>');">
                <div class="meta-date text-center p-2">
                  <span class="day"><?php echo e($news_event->type); ?></span>
                </div>
              </a>
              <div class="text border border-top-0 p-4" data-aos="fade-up">
                <h3 class="heading"><a href="<?php echo e(route('news-events.details',$news_event->slug)); ?>"><?php echo e($news_event->title); ?></a></h3>
                <p><?php echo Str::limit($news_event->description, 100); ?></p>
                <div class="d-flex align-items-center mt-4">
                  <p class="mb-0"><a href="<?php echo e(route('news-events.details',$news_event->slug)); ?>">Read More</a></p>
                  <p class="ml-auto mb-0">
                    <a href="<?php echo e(route('news-events.details',$news_event->slug)); ?>" class="mr-2"><?php echo e(Carbon\Carbon::parse($news_event->date)->format('d M Y')); ?></a>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xl-12" data-aos="fade-up">
                                        <div class="more_courses text-center">
                                            <a class="boxed_btn_rev"><?php echo e($news_events->links()); ?></a>
                                        </div>
                                    </div>
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/news_events.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<section class="qualifications_icrq">
     <div class="container">
          <h1 class="mb-5" data-aos="fade-up">Corporate Training</h1>
          <hr class="card-title-line" data-aos="fade-up">
          <div class="row" id="myTabContent">
          	<?php $__currentLoopData = $corporate_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
                                        <div class="single_courses">
                                            <div class="thumb">
                                                <a href="<?php echo e(route('corporate-training.details', $category->slug )); ?>">
                                                    <img src="<?php echo e(asset('/storage/'.$category->cover_image)); ?>" class="img-fluid" alt="Responsive image">
                                                </a>
                                            </div>
                                            <div class="courses_info text-center pt-4 pb-4">
                                                <h5><a href="<?php echo e(route('corporate-training.details', $category->slug )); ?>"><?php echo e($category->category_name); ?></a></h5>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </div>
     </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/corporate_training.blade.php ENDPATH**/ ?>
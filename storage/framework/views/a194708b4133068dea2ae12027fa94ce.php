<?php $__env->startSection('content'); ?>
<section class="Where-To-Study_icrq">
     <div class="container">
          <h2 class="mb-5" data-aos="fade-up">Our Centers</h2>
              <div class="row">
                    <div class="col-md-12" data-aos="fade-up">
                          <div class="card mb-3">
                               <div class="row no-gutters">
                                    <div class="col-xl-8 col-lg-7 col-md-6">
                                         <img src="<?php echo e(asset('web_dashboard/images/Where-To-Study-4.jpg')); ?>" class="card-img" alt="responsive">
                                    </div>
                                        <div class="col-xl-4 col-lg-5 col-md-6" data-aos="fade-up">
                                             <div class="card-body">
                                                  <h5 class="card-title">Find A Course / Center</h5>
                                                  <hr class="card-title-line">
                                                       <p class="card-text mt-3"></p>
                                                       <button type="button" class="btn" onclick="window.location='<?php echo e(url('find-course-provider')); ?>';">Find A Course / Center</button>
                                             </div>
                                        </div>
                               </div>
                          </div> 
                  </div>
              </div>
     </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/where_to_study.blade.php ENDPATH**/ ?>
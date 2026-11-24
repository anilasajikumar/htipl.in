<?php $__env->startSection('content'); ?>

   <!-- Navbar -->

<section class="Where-To-Study_icrq">
     <div class="container">
          <h2 class="mb-5" data-aos="fade-up">Find A Course Provider</h2>
              <div class="row">
                    <div class="col-md-12" data-aos="fade-up">
                          <div class="card mb-3">
                               <div class="row no-gutters">
                                    <div class="col-xl-6">
                                         <img src="<?php echo e(asset('web_dashboard/images/Where-To-Study-4.jpg')); ?>" class="card-img" alt="responsive">
                                    </div>
                                        <div class="col-xl-6" data-aos="fade-up">
                                             <div class="find-course-form">
                             <form action="<?php echo e(route('find_center')); ?>" method="POST">
                             	<?php echo csrf_field(); ?>
                                   <div class="form-group">
                                          <label>Courses</label>
                                          <select class="form-control" name="qualification" required>
                                         <option value="" selected disabled>---Select Course---</option>
                                          <?php $__currentLoopData = $online_course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($value); ?>"><?php echo e($key); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </select>        
                                   </div>

                                    <div class="form-group">
                                         <label>Location</label>
                                         <select class="form-control" name="location" required>
                                         <option value="" selected disabled>---Select Location---</option>
                                         <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($value); ?>"><?php echo e($key); ?></option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         </select>
                                    </div>
                                    
                                     <button type="submit" class="btn mt-3">Find</button>
                             </form>
                           </div>
                       </div>
                   </div>
                </div> 
            </div>
         </div>
     </div>
</section>

<?php if(!$data->isEmpty()): ?>
<section>
     <div class="container">
          <h2 class="mb-5" data-aos="fade-up">Study Centers</h2>
              <div class="row find-course">
              	<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-xl-4 col-lg-4 col-md-6" data-aos="fade-up">
                       <div class="single_courses">
                          <div class="thumb">
                             <a href="#">
                               <img src="<?php echo e(asset('/storage/'.$center->logo)); ?>" class="img-fluid" alt="Responsive image">
                              </a>
                          </div>
                          <div class="courses_info text-center pt-4 pb-2">
                            <div class="find-course-bottom text-left">
                              <h4><?php echo e($center->study_center_name); ?></h4>
                              <p><?php echo e($center->study_center_email); ?></p>
                              <p><?php echo e($center->study_center_address); ?></p>
                              <p><?php echo e($center->study_center_mobile); ?></p>
                            </div>  
                          </div>
                       </div>
                     </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </div>
               </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/find_course.blade.php ENDPATH**/ ?>
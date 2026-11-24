<?php $__env->startSection('content'); ?>
<section class="about_icrq">
  
  <div class="container">
    <div class="row">
    <div class="col-md-7" data-aos="fade-up">
        <h2>Enquiry</h2>
      </div>
      <div class="col-md-5" data-aos="fade-up">
        
      </div>
    </div>
              <div class="col-md-12 mt-5" data-aos="fade-up">

                  <div class="row" data-aos="fade-up">
                        <div class="col-md-6">
                             <form action="<?php echo e(route('apply_now')); ?>" method="POST">
                             	<?php echo csrf_field(); ?>
                              <h4 class="mb-5">Complete the Enquiry Form Below</h4>
                              <div class="form-group">
                                 <label>Name <span class="text-danger">*</span></label>
                                 <input type="name" name="name" class="form-control" required>               
                              </div>

                              <div class="form-group">
                                 <label>Email <span class="text-danger">*</span></label>
                                 <input type="email" name="email" class="form-control" required>
                              </div>

                              <div class="form-group">
                                 <label>Contact Number <span class="text-danger">*</span></label>
                                 <input type="number" name="contact_number" class="form-control" required>
                              </div>

                              <div class="form-group">
                                 <label>Centre <span class="text-danger">*</span></label>
                                 <select name="center" id="study_center" class="form-control" required>
                                  <option value="" selected>--Choose Center--</option>
                                  <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($value); ?>"><?php echo e($key); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                              </div>


                              <div class="form-group">
                                 <label>Course <span class="text-danger">*</span></label>
                                 <select name="course" id="course" class="form-control" required>
                                  <option value="" selected>--Choose Course--</option>
                                  <?php $__currentLoopData = $course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($value); ?>"><?php echo e($key); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                              </div>

                              <div class="form-group">
                                 <label>Message</label>
                                 <textarea type="text" name="message" class="form-control" required></textarea>
                              </div>

                               
                               <br>
                                    
                              <button type="submit" class="btn mt-3">Submit</button>
                             </form>
                        </div>
                        
                        <div class="col-md-1"></div>

                        
              </div>                       
     </div>
  </div>

</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
  $(function () {
    $('#study_center').change(function(e) {
        e.preventDefault();   
        var study_center = $('#study_center').val();
        $.ajax({
            url: '/study-center/course/'+study_center,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(data) {
            $('#course').html();
            var html = '<option value="">----Select----</option>';
            html += data;
            $('#course').html(html);
            
        })
        .fail(function() {
        })
        .always(function() {
        });
        
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/become_center_application.blade.php ENDPATH**/ ?>
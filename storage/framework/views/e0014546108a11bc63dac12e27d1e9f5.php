

<?php $__env->startSection('style'); ?>


<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
    
    $student = session('student_data');
?>




<?php if(session('error')): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="errorToast" class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <?php echo e(session('error')); ?>

      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<?php endif; ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<section class="checkcart_icrq">
    <div class="container">
       <h2 class="mb-3" data-aos="fade-up" style="color: #f46b1a;">
    How to verify HTI PVT LTD certificate
</h2>
        <p data-aos="fade-up">
            The HTI PVT LTD checkcert portal allows you to validate your own or other people’s certificates without needing the physical certificate.
            This means that potential employers can validate a certificate quickly and securely.<br>
            To verify certificate information, please enter the  certificate number into the template provided.
        </p>

        <div class="verify col-md-12 mt-5" data-aos="fade-up">
            <div class="row" data-aos="fade-up">
                <div class="col-md-6" style="margin:auto 0;">
                    <img class="Study-img img-fluid" src="<?php echo e(asset('web_dashboard/images/logo1.png')); ?>" alt="Responsive image">
                </div>
                <div class="col-md-6">
                    
                    <form method="POST" action="<?php echo e(route('checkcertificate')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="CertificateNumber">Register Number</label>
                            <input type="text" class="form-control" id="CertificateNumber" name="certificate_number" required>
                        </div>
                        
                        <button type="submit" class="btn btn-lg btn-block text-white" style="background-color: #f46b1a; border-color: #f46b1a;">
    Verify
</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(!empty($student)): ?>
<div class="modal fade show" id="certificateModal" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f46b1a; color: white;">
        <h5 class="modal-title">Diploma Certificate Verified</h5>
        <button type="button" class="btn-close btn-close-white" onclick="document.getElementById('certificateModal').style.display='none'" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row">
    <div class="col-md-6">
      <p><strong>Name:</strong> <?php echo e($student['name']); ?></p>
      <p><strong>Register Number:</strong> <?php echo e($student['register_number']); ?></p>
      <p><strong>Course:</strong> <?php echo e($student['course']); ?></p>
     
    </div>
    <div class="col-md-6">
      <p><strong>Gender:</strong> <?php echo e($student['gender']); ?></p>
      <p><strong>Date of Birth:</strong> <?php echo e(\Carbon\Carbon::parse($student['dob'])->format('d-m-Y')); ?></p>
      <p><strong>Passout (Month & Year):</strong> <?php echo e($student['passout']); ?></p>
    </div>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn text-white" style="background-color: #f46b1a; border-color: #f46b1a;" onclick="document.getElementById('certificateModal').style.display='none'">Close</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

</section>



<script>
    window.addEventListener('load', function () {
        var toastEl = document.getElementById('successToast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/checkcert.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Create Trainor</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <form method="POST" action="<?php echo e(route('trainor.store')); ?>">
      <?php echo csrf_field(); ?>
      <div class="form-group">
        <label>Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>">
        <small class="text-danger"><?php echo e($errors->first('name')); ?></small>
      </div>
      <div class="form-group">
        <label>Email <span class="text-danger">*</span></label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>">
        <small class="text-danger"><?php echo e($errors->first('email')); ?></small>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="form-control">
      </div>
      <div class="form-group">
        <label>Batch</label>
        <select name="batch_id" class="form-control">
          <option value="">-- No Batch --</option>
          <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($batch->id); ?>" <?php echo e(old('batch_id') == $batch->id ? 'selected' : ''); ?>><?php echo e($batch->title); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="form-group">
        <label>Expertise</label>
        <input type="text" name="expertise" value="<?php echo e(old('expertise')); ?>" class="form-control">
      </div>
      <div class="form-group">
        <label>Password <span class="text-danger">*</span></label>
        <input type="password" name="password" required class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>">
        <small class="text-danger"><?php echo e($errors->first('password')); ?></small>
      </div>
      <div class="form-group">
        <label>Confirm Password <span class="text-danger">*</span></label>
        <input type="password" name="password_confirmation" required class="form-control">
      </div>
      <button class="btn btn-primary">Submit</button>
      <a href="<?php echo e(route('trainor.index')); ?>" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/admin/trainor/create.blade.php ENDPATH**/ ?>
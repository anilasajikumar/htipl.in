<?php $__env->startSection('content'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Register Diploma Student</h1>
            <div class="section-header-button">
                <a href="<?php echo e(route('diploma.index')); ?>" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="<?php echo e(route('diploma.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="card-body">

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="course_id" class="form-control <?php echo e($errors->has('course_id') ? 'is-invalid' : ''); ?>" required>
                                        <option value="">-- Select Course --</option>
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>>
                                                <?php echo e($course->course_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="text-danger"><?php echo e($errors->first('course_id')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Student Name <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" name="name" required class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('name')); ?>">
                                    <small class="text-danger"><?php echo e($errors->first('name')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Father Name <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" name="father_name" required class="form-control <?php echo e($errors->has('father_name') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('father_name')); ?>">
                                    <small class="text-danger"><?php echo e($errors->first('father_name')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="email" name="email" required class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>">
                                    <small class="text-danger"><?php echo e($errors->first('email')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="number" name="mobile" required class="form-control <?php echo e($errors->has('mobile') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('mobile')); ?>">
                                    <small class="text-danger"><?php echo e($errors->first('mobile')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date of Birth <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="date" name="dob" required class="form-control <?php echo e($errors->has('dob') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('dob')); ?>">
                                    <small class="text-danger"><?php echo e($errors->first('dob')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gender <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7 pt-2">
                                    <label class="radio-inline mr-3"><input type="radio" name="gender" value="male" <?php echo e(old('gender','male') == 'male' ? 'checked' : ''); ?>> Male</label>
                                    <label class="radio-inline mr-3"><input type="radio" name="gender" value="female" <?php echo e(old('gender') == 'female' ? 'checked' : ''); ?>> Female</label>
                                    <label class="radio-inline"><input type="radio" name="gender" value="other" <?php echo e(old('gender') == 'other' ? 'checked' : ''); ?>> Others</label>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea required name="address" class="form-control <?php echo e($errors->has('address') ? 'is-invalid' : ''); ?>"><?php echo e(old('address')); ?></textarea>
                                    <small class="text-danger"><?php echo e($errors->first('address')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Passout Year & Month <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7 d-flex" style="gap:10px">
                                    <select name="passout_year" class="form-control" required>
                                        <option value="">Year</option>
                                        <?php for($y = 1980; $y <= now()->year + 5; $y++): ?>
                                            <option value="<?php echo e($y); ?>" <?php echo e(old('passout_year') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select name="passout_month" class="form-control" required>
                                        <option value="">Month</option>
                                        <?php for($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?php echo e(str_pad($m,2,'0',STR_PAD_LEFT)); ?>" <?php echo e(old('passout_month') == str_pad($m,2,'0',STR_PAD_LEFT) ? 'selected' : ''); ?>>
                                                <?php echo e(DateTime::createFromFormat('!m',$m)->format('F')); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-7 offset-md-3">
                                    <small class="text-danger"><?php echo e($errors->first('passout_year')); ?> <?php echo e($errors->first('passout_month')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Proof (PDF)</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="file" name="id_proof" accept="application/pdf" class="form-control">
                                    <small class="text-danger"><?php echo e($errors->first('id_proof')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Photo</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="file" name="image" accept="image/*" class="form-control">
                                    <small class="text-danger"><?php echo e($errors->first('image')); ?></small>
                                </div>
                            </div>

                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-primary">Register Student</button>
                                    <a href="<?php echo e(route('diploma.index')); ?>" class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/admin/diploma/create.blade.php ENDPATH**/ ?>
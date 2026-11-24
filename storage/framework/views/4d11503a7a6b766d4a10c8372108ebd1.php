<?php $__env->startSection('content'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Diploma Students</h1>
            <div class="section-header-button">
                <a href="<?php echo e(route('diploma.create')); ?>" class="btn btn-primary">Add New</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Diploma Student List</h4>
                    </div>
                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="diploma-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Father Name</th>
                                        <th>Course</th>
                                        <th>Register No.</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Passout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($i + 1); ?></td>
                                        <td><?php echo e($s->student_name); ?></td>
                                        <td><?php echo e($s->father_name); ?></td>
                                        <td><?php echo e($s->course_name); ?></td>
                                        <td><strong><?php echo e($s->register_number); ?></strong></td>
                                        <td><?php echo e($s->email); ?></td>
                                        <td><?php echo e($s->mobile); ?></td>
                                        <td><?php echo e($s->passout_year_month); ?></td>
                                        <td>
                                            <form action="<?php echo e(route('diploma.destroy', $s->id)); ?>" method="POST"
                                                onsubmit="return confirm('Delete this student?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No diploma students found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $('#diploma-table').DataTable({ responsive: true });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/admin/diploma/index.blade.php ENDPATH**/ ?>
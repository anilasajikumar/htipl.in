
<style>
    table thead th {
        font-size: 16px;
        font-weight: 600;
    }
</style>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">

    <h2 class="mb-4">Placement Opportunities</h2>

    <table class="table table-bordered mt-4 mb-5">
        <thead style="background-color: #fd7e14;">
            <tr class="text-white text-center">
                <th scope="col">POST NAME</th>
                <th scope="col">EXPERIENCE</th>
                <th scope="col">COMPANY AND LOCATION</th>
                <th scope="col">SALARY</th>
                <th scope="col">QUALIFICATION</th>
                <th scope="col">LAST DATE TO APPLY</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $placements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="text-center">
                <td class="table-secondary"><?php echo e($data->post_name); ?></td>
                <td class="table-secondary"><?php echo e($data->experience); ?></td>
                <td class="table-secondary"><?php echo e($data->company); ?></td>
                <td class="table-secondary"><?php echo e($data->salary); ?></td>
                <td class="table-secondary"><?php echo e($data->qualification); ?></td>
                <td class="table-secondary"><?php echo e($data->last_date_to_apply); ?></td>
                <td class="table-secondary">
                    <a href="<?php echo e(route('placement.apply', $data->id)); ?>" 
                       class="btn btn-primary btn-sm">
                        Apply Now
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/website/placements.blade.php ENDPATH**/ ?>
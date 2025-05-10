<?php if(Session::has('sticky_error')): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">×</span> </button>
        <h3 class="text-danger"><i class="fa fa-times-circle"></i> Error</h3> 
        <?php echo Session::get('sticky_error'); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('sticky_success')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">×</span> </button>
        <h3 class="text-success"><i class="fa fa-check-circle"></i> Success</h3> 
        <?php echo Session::get('sticky_success'); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
        <span aria-hidden="true">×</span> </button>
    <h3 class="text-danger"><i class="fa fa-times-circle"></i> Error</h3> 
    <div>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>
<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/layouts/partials/messages.blade.php ENDPATH**/ ?>
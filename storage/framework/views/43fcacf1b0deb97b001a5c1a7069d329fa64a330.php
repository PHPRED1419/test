
<!-- ============================================================== -->
<!-- Top Show Data of List Blog -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='<?php echo e(route('admin.keywords.index')); ?>'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white"><?php echo e($count_keywords); ?></h1>
                <h6 class="text-white">Total Sizes</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='<?php echo e(route('admin.keywords.index')); ?>'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white"><?php echo e($count_active_keywords); ?></h1>
                <h6 class="text-white">Active Sizes</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='<?php echo e(route('admin.keywords.trashed')); ?>'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white"><?php echo e($count_keywords - $count_active_keywords); ?> / <?php echo e($count_trashed_keywords); ?> </h1>
                <h6 class="text-white">Inactive/Trashed Sizes</h6>
            </div>
        </div>
    </div>

    <?php if(Auth::user()->can('keywords.create')): ?>
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='<?php echo e(route('admin.keywords.create')); ?>'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Size</h6>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/pages/keywords/partials/top-show.blade.php ENDPATH**/ ?>
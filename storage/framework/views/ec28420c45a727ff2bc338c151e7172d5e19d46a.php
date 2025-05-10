
<!-- ============================================================== -->
<!-- Top Show Data of Categorie List Page -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='<?php echo e(route('admin.categories.index')); ?>'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white"><?php echo e($count_categories); ?></h1>
                <h6 class="text-white">Total Categories</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='<?php echo e(route('admin.categories.index')); ?>'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white"><?php echo e($count_active_categories); ?></h1>
                <h6 class="text-white">Active Categories</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='<?php echo e(route('admin.categories.trashed')); ?>'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white"><?php echo e($count_categories - $count_active_categories); ?> / <?php echo e($count_trashed_categories); ?> </h1>
                <h6 class="text-white">Inactive/Trashed Categories</h6>
            </div>
        </div>
    </div>

    <?php if(Auth::user()->can('category.create')): ?>
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='<?php echo e(route('admin.categories.create')); ?>'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Category</h6>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/categories/partials/top-show.blade.php ENDPATH**/ ?>
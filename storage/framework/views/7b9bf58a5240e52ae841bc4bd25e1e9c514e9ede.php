<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                <?php if(Route::is('admin.categories.index')): ?>
                    Category List
                <?php elseif(Route::is('admin.categories.create')): ?>
                    Create New Category    
                <?php elseif(Route::is('admin.categories.edit')): ?>
                    Edit Category <span class="badge badge-info"><?php echo e($category->name); ?></span>
                <?php endif; ?>
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Home</a></li>
                        <?php if(Route::is('admin.categories.index')): ?>
                            <li class="breadcrumb-item active" aria-current="page">Category List</li>
                        <?php elseif(Route::is('admin.categories.create')): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.categories.index')); ?>">Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Category</li>
                        <?php elseif(Route::is('admin.categories.edit')): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.categories.index')); ?>">Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                        <?php endif; ?>
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/categories/partials/header-breadcrumbs.blade.php ENDPATH**/ ?>
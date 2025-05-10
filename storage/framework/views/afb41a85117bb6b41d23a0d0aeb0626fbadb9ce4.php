<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                <?php if(Route::is('admin.keywords.index')): ?>
                keywords List
                <?php elseif(Route::is('admin.keywords.create')): ?>
                    Create New keywords    
                <?php elseif(Route::is('admin.keywords.edit')): ?>
                    Edit keywords 
                <?php elseif(Route::is('admin.keywords.show')): ?>
                    View keywords </span>
                    <a  class="btn btn-outline-success btn-sm" href="<?php echo e(route('admin.keywords.edit', $keywords->id)); ?>"> <i class="fa fa-edit"></i></a>
                <?php endif; ?>
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Home</a></li>
                        <?php if(Route::is('admin.keywords.index')): ?>
                            <li class="breadcrumb-item active" aria-current="page">keywords List</li>
                        <?php elseif(Route::is('admin.keywords.create')): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.keywords.index')); ?>">keywords List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New keywords</li>
                        <?php elseif(Route::is('admin.keywords.edit')): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.keywords.index')); ?>">keywords List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit keywords</li>
                        <?php elseif(Route::is('admin.keywords.show')): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.keywords.index')); ?>">keywords List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">keywords</li>
                        <?php endif; ?>
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/pages/keywords/partials/header-breadcrumbs.blade.php ENDPATH**/ ?>
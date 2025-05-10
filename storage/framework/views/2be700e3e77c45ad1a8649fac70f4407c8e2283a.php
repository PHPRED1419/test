<?php if(Route::is('admin.keywords.index')): ?>
keywords 
<?php elseif(Route::is('admin.keywords.create')): ?>
Create New keywords
<?php elseif(Route::is('admin.keywords.edit')): ?>
Edit keywords <?php echo e($keywords->title); ?>

<?php elseif(Route::is('admin.keywords.show')): ?>
View keywords <?php echo e($keywords->title); ?>

<?php endif; ?>
| Admin Panel - 
<?php echo e(config('app.name')); ?><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/pages/keywords/partials/title.blade.php ENDPATH**/ ?>
<?php if(Route::is('admin.categories.index')): ?>
Categories
<?php elseif(Route::is('admin.categories.create')): ?>
Create New Category
<?php elseif(Route::is('admin.categories.edit')): ?>
Edit Category - <?php echo e($category->name); ?>

<?php elseif(Route::is('admin.categories.trashed')): ?>
Trashed Categories
<?php endif; ?>
| Admin Panel -
<?php echo e(config('app.name')); ?>

<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/categories/partials/title.blade.php ENDPATH**/ ?>
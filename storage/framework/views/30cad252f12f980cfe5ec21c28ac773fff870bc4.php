<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <?php echo $__env->make('frontend.layouts.partials.meta_tags', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('social_meta_tags'); ?>
    <?php echo $__env->make('frontend.layouts.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
<?php echo $__env->make('frontend.layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>       
        <?php echo $__env->yieldContent('main-content'); ?> 
<?php echo $__env->make('frontend.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php echo $__env->make('frontend.layouts.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/frontend/layouts/master.blade.php ENDPATH**/ ?>
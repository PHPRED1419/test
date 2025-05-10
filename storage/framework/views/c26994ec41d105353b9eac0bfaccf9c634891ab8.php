
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $__env->make('backend.layouts.partials.meta_tags', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <?php echo $__env->make('backend.layouts.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('styles'); ?>    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id="></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '');
    </script>  

    <!--Ckeditor4 -->
<script src="<?php echo e(asset('public/js/ckeditor/ckeditor.js')); ?>"></script>
<!--This page Ckeditor4 -->
</head>
<body>
    <?php echo $__env->make('backend.layouts.partials.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div id="main-wrapper">
        <?php echo $__env->make('backend.layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>        
        <?php echo $__env->make('backend.layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>        
        <div class="page-wrapper"> 
            <?php echo $__env->yieldContent('admin-content'); ?>
            <?php echo $__env->make('backend.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>           
        </div>       
    </div> 
    <?php echo $__env->make('backend.layouts.partials.theme-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('backend.layouts.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/layouts/master.blade.php ENDPATH**/ ?>
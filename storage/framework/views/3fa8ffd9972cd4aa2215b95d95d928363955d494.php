
<?php $__env->startSection('title'); ?>
    <?php echo e(config('app.name')); ?> | <?php echo e(config('app.description')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
<?php echo $__env->make('frontend.layouts.partials.inner-banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php 
if(isset($slug))
{		
	echo generateCategoryBreadcrumbs($slug);
}?>

<?php /*?><nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a></li>
<li class="breadcrumb-item">Category</li>
</ol>
<?php 
if(isset($slug))
{		
	//echo generateCategoryBreadcrumbs($slug);
}?>
</div>
</nav><?php */?>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Category</h1>

<div class="row row-cols-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-2 cate_list">
<?php if(!empty($data)): ?>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col">
        <div class="cate_box position-relative "> 
        <div class="cate_pic overflow-hidden text-center m-auto rounded-3">
        <figure class="d-table-cell align-middle text-center"><a href="<?php echo e(url('category/' . $row->slug)); ?>" title=" $row->name  }}">
        <?php if($row->category_image != ""): ?>
            <img src="<?php echo e(asset('assets/images/categories/' . $row->category_image)); ?>" alt="" loading="lazy" fetchpriority="low" decoding="async" width="281" height="283">
        <?php else: ?>
            <img src="<?php echo e(asset('assets/frontend/images/no_image.png')); ?>" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 389px;height: 389px;">
        <?php endif; ?>      
        </a></figure></div>
        <div class="text-center">
        <p class="cate_name overflow-hidden text-center fw-bold vollkorn"><a href="<?php echo e(url('category/' . $row->slug)); ?>" title="<?php echo e($row->name); ?>"><?php echo e($row->name); ?></a></p>
        </div></div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

</div>




</div>
</div>
</div>



<div class="clearfix"></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\Modules/Category\Resources/views/human_resource_sub_page.blade.php ENDPATH**/ ?>
<?php
$inner_banner = getInnerBanner();
?>

<!--Header end-->
<?php if(!empty($inner_banner)): ?>
<!--Banner-->
<div class="inner_bnr"> 
<img src="<?php echo e(asset('assets/images/banners/' . $inner_banner)); ?>" class="" alt="" loading="lazy" fetchpriority="low" decoding="async">
</div>
<!--Banner end-->
<?php endif; ?>

<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/frontend/layouts/partials/inner-banner.blade.php ENDPATH**/ ?>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?php echo e(asset('public/assets/backend/js/jquery.min.js')); ?>"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo e(asset('public/assets/backend/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/bootstrap.min.js')); ?>"></script>
<!-- apps -->
<script src="<?php echo e(asset('public/assets/backend/js/app.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/app.init.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/app-style-switcher.js')); ?>"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo e(asset('public/assets/backend/js/perfect-scrollbar.jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/sparkline.js')); ?>"></script>
<!--Wave Effects -->
<script src="<?php echo e(asset('public/assets/backend/js/waves.js')); ?>"></script>
<!--Menu sidebar -->
<script src="<?php echo e(asset('public/assets/backend/js/sidebarmenu.js')); ?>"></script>

<!-- Data Tables -->
<script src="<?php echo e(asset('public/assets/backend/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/datatable/datatables/dataTables.bootstrap4.min.js')); ?>"></script>


<!-- Sweet Alert -->
<script src="<?php echo e(asset('public/assets/backend/js/sweetalert2/dist/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/sweetalert2/sweet-alert.init.js')); ?>"></script>
<!-- Sweet Alert -->

<!-- Parsley JS -->
<script src="<?php echo e(asset('public/assets/backend/js/parsley/parsley.min.js')); ?>"></script>
<!-- Parsley JS -->

<!-- Toaster JS -->
<script src="<?php echo e(asset('public/assets/backend/js/toaster/toastr.min.js')); ?>"></script>
<!-- Toaster JS -->

<!-- Select2 JS -->
<script src="<?php echo e(asset('public/assets/backend/js/select2/select2.min.js')); ?>"></script>
<script> $(".select2").select2(); $('[data-toggle="tooltip"]').tooltip();</script>
<!-- Select2 JS -->


<!-- Tiny MCE JS -->
<script src="<?php echo e(asset('public/assets/backend/js/tinymce/tinymce.min.js')); ?>"></script>
<!-- Tiny MCE JS -->


<!-- Dropify JS -->
<script src="<?php echo e(asset('public/assets/backend/js/dropify/js/dropify.min.js')); ?>"></script>
<script> $(".dropify").dropify(); </script>
<!-- Dropify JS -->

<!--Custom JavaScript -->
<script src="<?php echo e(asset('public/assets/backend/js/custom.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/backend/js/init.js')); ?>"></script>
<!--This page JavaScript -->









<?php echo $__env->make('backend.layouts.partials.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/layouts/partials/scripts.blade.php ENDPATH**/ ?>
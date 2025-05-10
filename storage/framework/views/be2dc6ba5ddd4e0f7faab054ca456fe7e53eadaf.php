
<?php if(Session::has('success')): ?>
    <script>
        toastr.success( "<?php echo Session::get('success'); ?>", 'Success', 
            { "showMethod": "fadeIn", "hideMethod": "fadeOut", timeOut: 2000 }
        );
    </script>
<?php endif; ?>

<?php if(Session::has('error')): ?>
    <script>
        toastr.error( "<?php echo Session::get('error'); ?>", 'Error', 
            { "showMethod": "fadeIn", "hideMethod": "fadeOut", timeOut: 2000 }
        );
    </script>
<?php endif; ?>

<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/layouts/partials/flash-message.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?>
    <?php echo $__env->make('backend.pages.keywords.partials.title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
    <?php echo $__env->make('backend.pages.keywords.partials.header-breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <?php echo $__env->make('backend.pages.keywords.partials.top-show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('backend.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <button id="deleteSelected" class="btn btn-danger mb-3">Delete</button>
        <div class="table-responsive product-table">
            <table class="table table-striped table-bordered display ajax_view" id="sizes_table">
                <thead>
                    <tr>
                        <th class="no-sort" data-orderable="false" width="5%"><input type="checkbox" id="select-all"></th>
                        <th  width="10%">Sl</th>
                        <th  width="60%">Title</th>
                        <th  width="10%">Status</th>
                        <th  width="15%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    const ajaxURL = "<?php echo e(route(Route::is('admin.keywords.trashed') ? 'admin.keywords.trashed.view' : 'admin.keywords.index')); ?>";

    const table = $('#sizes_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: ajaxURL,
        dom: 'Blfrtip',
        aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        buttons: ['excel', 'pdf', 'print'],
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'keywords_name', name: 'keywords_name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        columnDefs: [
            {
                targets: 0,
                className: 'no-sort',
                createdCell: function(td) {
                    $(td).removeClass('sorting sorting_asc sorting_desc');
                }
            }
        ],
        select: { style: 'multi' }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('public/assets/backend/css/custom.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/pages/keywords/index.blade.php ENDPATH**/ ?>
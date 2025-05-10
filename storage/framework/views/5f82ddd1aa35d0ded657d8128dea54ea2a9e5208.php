

<?php $__env->startSection('title'); ?>
    <?php echo $__env->make('backend.categories.partials.title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
    <?php echo $__env->make('backend.categories.partials.header-breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <?php echo $__env->make('backend.categories.partials.top-show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('backend.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

        <button id="deleteSelected" class="btn btn-danger mb-3">Delete Selected</button>
        <div class="table-responsive product-table">
            <table class="table table-striped table-bordered display ajax_view" id="categories_table">
                <thead>
                    <tr>
                        <th class="no-sort" data-orderable="false"><input type="checkbox" id="select-all"></th>
                        <th>Sl</th>
                        <th>Parent Category</th>
                        <th>Sub Category</th>                        
                        
                        <th>Image</th>
                        <th>Display Order</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    const ajaxURL = "<?php echo Route::is('admin.categories.trashed' ? 'categories/categories/view' : 'categories') ?>";
    const table = $('table#categories_table').DataTable({
        dom: 'Blfrtip',
        language: {processing: "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'>Loading Data...</span>"},
        processing: true,
        serverSide: true,
        ajax: {url: ajaxURL},
        aLengthMenu: [[12, 50, 100, 1000, -1], [12, 50, 100, 1000, "All"]],
        buttons: ['excel', 'pdf', 'print'],
        columns: [
            {
                data: 'checkbox', 
                name: 'checkbox', 
                orderable: false, // Disable sorting for this column
                searchable: false
            },
           // {data: 'id', name: 'id'},
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},            
            {data: 'parent_category', name: 'parent_category'},
            {data: 'sub_category', name: 'name'},
           // {data: 'banner_image', name: 'banner_image'},
            {data: 'category_image', name: 'category_image'},
            {data: 'priority', name: 'priority'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'}
        ],
        columnDefs: [
            {
                targets: 0, // Target the first column (checkbox column)
                orderable: false, // Ensure sorting is disabled for this column
                className: 'no-sort', // Add a custom class to the checkbox column
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).removeClass('sorting sorting_asc sorting_desc sorting_disabled');
                }
            }
        ],
        select: {
            style: 'multi'
        }
    });

    // Handle "Select All" checkbox
    $('#select-all').on('click', function() {
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle delete button click
    $('#deleteSelected').on('click', function() {
        var selected = [];
        $('input[type="checkbox"]:checked', table.rows({ 'search': 'applied' }).nodes()).each(function() {
            selected.push($(this).val());
        });

        if (selected.length > 0) {
            if (confirm('Are you sure you want to delete the selected records?')) {
                $.ajax({
                    url: '<?php echo e(route("admin.categories.delete.multiple")); ?>',
                    type: 'POST',
                    data: {
                        ids: selected,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();
                            alert('Selected records have been deleted.');
                        } else {
                            alert('An error occurred while deleting the records.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the records.');
                    }
                });
            }
        } else {
            alert('No records selected.');
        }
    });
});
    	
function full_view(ele){
    let src=ele.parentElement.querySelector(".img-source").getAttribute("src");
    document.querySelector("#img-viewer").querySelector("img").setAttribute("src",src);
    document.querySelector("#img-viewer").style.display="block";
}

function close_model(){
    document.querySelector("#img-viewer").style.display="none";
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('public/assets/backend/css/custom.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/categories/index.blade.php ENDPATH**/ ?>
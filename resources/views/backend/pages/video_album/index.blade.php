@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.video_album.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.video_album.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.pages.video_album.partials.top-show')
        @include('backend.layouts.partials.messages')

        <button id="deleteSelected" class="btn btn-danger mb-3">Delete</button>
        <div class="table-responsive product-table">
            <table class="table table-striped table-bordered display ajax_view" id="video_album_table">
                <thead>
                    <tr>
                        <th width="6%" class="no-sort" data-orderable="false"><input type="checkbox" id="select-all"></th>
                        <th>Sl</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const ajaxURL = "<?php echo Route::is('admin.video_album.trashed' ? 'video_album/trashed/view' : 'video_album') ?>";
    const table = $('table#video_album_table').DataTable({
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
            {data: 'category_name', name: 'category_name'},
            {data: 'category_image', name: 'category_image'},
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
                    url: '{{ route("admin.video_album.delete.multiple") }}',
                    type: 'POST',
                    data: {
                        ids: selected,
                        _token: '{{ csrf_token() }}'
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
   // table.processing(false);
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
@endsection

@section('styles')
<link href="{{ asset('public/assets/backend/css/custom.css') }}" rel="stylesheet">
@endsection

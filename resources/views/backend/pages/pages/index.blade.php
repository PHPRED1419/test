@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.pages.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.pages.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.pages.pages.partials.top-show')
        @include('backend.layouts.partials.messages')
        
        <div class="table-responsive product-table">
            <table class="table table-striped table-bordered display ajax_view" id="pages_table">
                <thead>
                    <tr>
                        <th class="no-sort" data-orderable="false" width="5%">Sl</th>
                        <th  width="60%">Title</th>
                        <th  width="10%">Status</th>
                        <th  width="15%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const ajaxURL = "<?php echo Route::is('admin.pages.trashed' ? 'pages/trashed/view' : 'pages') ?>";
    const table = $('table#pages_table').DataTable({
        dom: 'Blfrtip',
        language: {processing: "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'>Loading Data...</span>"},
        processing: true,
        serverSide: true,
        ajax: {url: ajaxURL},
        aLengthMenu: [[12, 50, 100, 1000, -1], [12, 50, 100, 1000, "All"]],
        buttons: ['excel', 'pdf', 'print'],
        columns: [            
           // {data: 'id', name: 'id'},
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
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

});    	

</script>
@endsection

@section('styles')
<link href="{{ asset('public/assets/backend/css/custom.css') }}" rel="stylesheet">
@endsection

@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.instant_offer_enquiry.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.instant_offer_enquiry.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.pages.instant_offer_enquiry.partials.top-show')
        @include('backend.layouts.partials.messages')

        <button id="deleteSelected" class="btn btn-danger mb-3">Delete</button>
        <div class="table-responsive product-table">
            <table class="table table-striped table-bordered display ajax_view" id="enquiry_table">
                <thead>
                    <tr>
                        <th class="no-sort" data-orderable="false" width="5%"><input type="checkbox" id="select-all"></th>
                        <th  width="10%">Sl</th>
                        <th  width="20%">Name</th>
                        <th  width="20%">Email</th>
                        <th>phone</th>
                        <th>Message</th>
                        <th>Posted Date</th>
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
    const ajaxURL = "<?php echo Route::is('admin.instant_offer_enquiry.trashed' ? 'instant_offer_enquiry/trashed/view' : 'instant_offer_enquiry') ?>";
    const table = $('table#enquiry_table').DataTable({
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
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'mobile', name: 'mobile'},  
            {data: 'message', name: 'message'}, 
            {data: 'created_at', name: 'created_at'},  
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
                    url: '{{ route("admin.instant_offer_enquiry.delete.multiple") }}',
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

</script>
@endsection

@section('styles')
<link href="{{ asset('public/assets/backend/css/custom.css') }}" rel="stylesheet">
@endsection

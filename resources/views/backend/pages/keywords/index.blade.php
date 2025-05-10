@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.keywords.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.keywords.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.pages.keywords.partials.top-show')
        @include('backend.layouts.partials.messages')

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
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const ajaxURL = "{{ route(Route::is('admin.keywords.trashed') ? 'admin.keywords.trashed.view' : 'admin.keywords.index') }}";

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
@endsection

@section('styles')
<link href="{{ asset('public/assets/backend/css/custom.css') }}" rel="stylesheet">
@endsection

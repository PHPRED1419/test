@extends('backend.layouts.master')

@section('title')
    @include('backend.products.partials.title')
@endsection

@section('admin-content')
    @include('backend.products.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.products.partials.top-show')
        @include('backend.layouts.partials.messages') 

        <button id="deleteSelected" class="btn btn-danger mb-3">Delete</button>
        <div class="table-responsive product-table">
            <table class="table table-striped table-bordered display ajax_view" id="products_table">
                <thead>
                    <tr>
                        <th class="no-sort" data-orderable="false"><input type="checkbox" id="select-all"></th>
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Image</th>
                        <th>Display Order</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<!-- Modal for Update Stock & Price -->
<div class="modal fade custom-modal table-responsive product-table" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class=" page-title" id="exampleModalLabel">Update Stock & Price</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    @include("backend.layouts.partials.messages")
                   
                    <form id="updateStockForm" action="" method="POST" onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')
                        <div class="form-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12" style="background-color: #ccc;">
                                        <div class="search-section mt-3">
                                            <p class="serch-sec1 fs13"><strong>Product Name -</strong> <span id="modalProductName"></span></p>
                                            <p class="serch-sec1 fs13"><strong>Product Code -</strong> <span id="modalProductCode"></span></p>
                                            <p class="clearfix"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box_style mob_scroll">
                                            <div class="recent-table">
                                                <table class="table table-striped table-bordered display">
                                                <thead class="thead-light">
                                                        <tr>
                                                            <th class="text-center fs13" width="14%"><b>Size</b></th>
                                                            <th class="text-center fs13" width="14%"><b>Color</b></th>
                                                            <th class="text-center fs13" width="14%"><b>Price</b></th>
                                                            <th class="text-center fs13" width="16%"><b>Dis. Price</b></th>
                                                            <th class="text-center fs13" width="14%"><b>Quantity</b></th>
                                                            <th class="text-center fs13" width="14%"><b>Low Stock</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="modalVariantBody">
                                                        <!-- Variant rows will be dynamically inserted here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Stock & Price</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    const ajaxURL = "<?php echo Route::is('admin.products.trashed' ? 'products/products/view' : 'products') ?>";
    const table = $('table#products_table').DataTable({
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
            {data: 'product_name', name: 'product_name'},
            {data: 'product_code', name: 'product_code'},
           // {data: 'banner_image', name: 'banner_image'},
            {data: 'media', name: 'media'},
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
                    url: '{{ route("admin.products.delete.multiple") }}',
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

<script>

    function loadModalData(productId, productName, productCode) {
        // Set product name and code
        document.getElementById('modalProductName').innerText = productName;
        document.getElementById('modalProductCode').innerText = productCode;

        // Update form action URL
        const form = document.getElementById('updateStockForm');
        form.action = `/admin/products/updateStock/${productId}`; // Update the action URL dynamically
       // $('#data_id').val(productId);
        // Fetch variants via AJAX (if needed)
        fetch(`products/variants/${productId}`)
            .then(response => response.json())
            .then(data => {
                const variantBody = document.getElementById('modalVariantBody');
                variantBody.innerHTML = ''; // Clear existing rows

                data.variants.forEach(variant => {
                    const row = `
                        <tr>
                            <td class="text-center fs13">${variant.size_name}</td>
                            <td class="text-center fs13">${variant.color_name}</td>
                            <td class="text-center fs13">
                                <input type="text" id="pp_${variant.stock_id}" name="pp_${variant.stock_id}" value="${variant.product_price}" class="form-control" onkeyup="return check_price_val(this.value, ${variant.stock_id});" required="">
                            </td>
                            <td class="text-center fs13">
                                <input type="text" id="dp_${variant.stock_id}" name="dp_${variant.stock_id}" value="${variant.product_discounted_price}" class="form-control" onkeyup="return check_dprice_val(this.value, ${variant.stock_id});">
                            </td>
                            <td class="text-center fs13">
                                <input type="text" id="qty_${variant.stock_id}" name="qty_${variant.stock_id}" value="${variant.product_quantity}" class="form-control" onkeyup="check_qty_val(this.value, ${variant.stock_id});">
                            </td>
                            <td class="text-center fs13">
                                <input type="text" id="inv_${variant.stock_id}" name="inv_${variant.stock_id}" value="${variant.inventory}" class="form-control" onkeydown="return check_qty_val_low_stock(this.value, ${variant.stock_id});">
                            </td>
                        </tr>
                    `;
                    variantBody.insertAdjacentHTML('beforeend', row);
                });
            });
    }

    $(document).ready(function() {
    // Handle the form submit event
    $('#updateStockForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        var formData = new FormData(this);

        // Send AJAX request
        $.ajax({
            url: $(this).attr('action'), 
            type: 'POST', 
            data: formData, 
            dataType: 'json',
            processData: false, 
            contentType: false, 
            success: function(response) {
                if (response.success) {                    
                    $('#exampleModal').modal('hide'); 
                    location.reload(); 
                } 
            },
            error: function(xhr, status, error) {
                // Show error message
                alert('An error occurred: ' + error);
            }
        });
    });
});


function validateForm() {
    let isValid = true;

    // Loop through all variants and validate their fields
    const variantRows = document.querySelectorAll('#modalVariantBody tr');
    variantRows.forEach(row => {
        const price = parseFloat(row.querySelector('input[name^="pp_"]').value);
        const quantity = parseFloat(row.querySelector('input[name^="qty_"]').value);
        const lowStock = parseFloat(row.querySelector('input[name^="inv_"]').value);
        const discountedPrice = parseFloat(row.querySelector('input[name^="dp_"]').value);

        // Validate price
        if (isNaN(price) || price <= 0) {
            alert("Please enter a valid price for all variants.");
            isValid = false;
            return false; // Exit the loop early
        }

        // Validate quantity
        if (isNaN(quantity) || quantity <= 0 || !Number.isInteger(quantity)) {
            alert("Please enter a valid quantity for all variants.");
            isValid = false;
            return false; // Exit the loop early
        }
 /*
        // Validate low stock
        if (isNaN(lowStock) || lowStock <= 0 || !Number.isInteger(lowStock)) {
            alert("Please enter a valid low stock value for all variants.");
            isValid = false;
            return false; // Exit the loop early
        }

        // Validate discounted price
       
        if (isNaN(discountedPrice) || discountedPrice <= 0 || discountedPrice > price) {
            alert("Please enter a valid discounted price for all variants.");
            isValid = false;
            return false; // Exit the loop early
        }
        */
    });

    return isValid; // Return true if all fields are valid
}

function check_qty_val(val,itemId)
{
	if((parseFloat(val) == parseInt(val)) && !isNaN(val)){
      return true;
  } else {
	  alert("Please Enter Integer value in quantity");
		$("#qty_"+itemId).val('');
		$("#qty_"+itemId).focus();
      return false;
  }

/*if(parseInt(val)){
    alert("Please Enter Integer value in quantity");
    $("#qty_"+itemId).val(0);
    $("#qty_"+itemId).focus();
    return false

}*/

}

function check_qty_val_low_stock(val,itemId){
	
	if(val<=0){
		alert("Please Enter Integer value in min stock");
		$("#inv_"+itemId).val(0);
		$("#inv_"+itemId).focus();
	}
}

function check_price_val(val,itemId){

	if(!jQuery.isNumeric(val)){
		alert("Please Enter Integer/Float value in price");
		$("#pp_"+itemId).val('');
		$("#pp_"+itemId).focus();
		return false;
	}
}

function check_dprice_val(val,itemId){

	var price = parseFloat(jQuery('#pp_'+itemId).val());
	var dprice = parseFloat(val);

	if(!jQuery.isNumeric(val)){
		alert("Please Enter Integer/Float value in discounted price");
		$("#dp_"+itemId).val('');
		$("#dp_"+itemId).focus();
		return false;
	}

	if(dprice > price){
		alert("Discounted price must be less than actual price.");
		$("#dp_"+itemId).val('');
		$("#dp_"+itemId).focus();
		return false;
	}
}

function check_deal_price_val(val,itemId){

	var price = parseFloat(jQuery('#pp_'+itemId).val());
	var dprice = parseFloat(val);

	if(!jQuery.isNumeric(val)){
		alert("Please Enter Integer/Float value in deal price");
		$("#dlp_"+itemId).val('');
		$("#dlp_"+itemId).focus();
		return false;
	}

	if(dprice > price){
		alert("Deal price must be less than actual price.");
		$("#dlp_"+itemId).val('');
		$("#dlp_"+itemId).focus();
		return false;
	}
}


</script>
@endsection

@section('styles')
<link href="{{ asset('public/assets/backend/css/custom.css') }}" rel="stylesheet">
@endsection

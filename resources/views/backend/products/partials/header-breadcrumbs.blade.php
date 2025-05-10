<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.products.index'))
                Product List
                @elseif(Route::is('admin.products.create'))
                    Create New Product    
                @elseif(Route::is('admin.products.edit'))
                    Edit Product 
                    <br /> <span class="badge badge-info">{{ $product->product_name }}</span>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.products.index'))
                            <li class="breadcrumb-item active" aria-current="page">Product List</li>
                        @elseif(Route::is('admin.products.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Product List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Product</li>
                        @elseif(Route::is('admin.products.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        @endif                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@if (Route::is('admin.products.index'))
Products
@elseif(Route::is('admin.products.create'))
Create New Product
@elseif(Route::is('admin.products.edit'))
Edit Product - {{ $product->product_name }}
@elseif(Route::is('admin.products.trashed'))
Trashed Products
@endif
| Admin Panel -
{{ config('app.name') }}

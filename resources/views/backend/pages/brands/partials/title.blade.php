@if (Route::is('admin.brands.index'))
Brands 
@elseif(Route::is('admin.brands.create'))
Create New Brand
@elseif(Route::is('admin.brands.edit'))
Edit Brand {{ $brand->title }}
@elseif(Route::is('admin.brands.show'))
View Brand {{ $brand->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
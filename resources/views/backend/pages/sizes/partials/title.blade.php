@if (Route::is('admin.sizes.index'))
Sizes 
@elseif(Route::is('admin.sizes.create'))
Create New Size
@elseif(Route::is('admin.sizes.edit'))
Edit Size {{ $size->title }}
@elseif(Route::is('admin.sizes.show'))
View Size {{ $sizes->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
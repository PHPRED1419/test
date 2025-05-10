@if (Route::is('admin.image_album.index'))
Image Albums 
@elseif(Route::is('admin.image_album.create'))
Create New Image Album
@elseif(Route::is('admin.image_album.edit'))
Edit Image Album {{ $category->category_name }}
@elseif(Route::is('admin.brands.show'))
View Image Album {{ $category->category_name }}
@endif
| Admin Panel - 
{{ config('app.name') }}
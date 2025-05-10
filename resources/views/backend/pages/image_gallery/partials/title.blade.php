@if (Route::is('admin.image_gallery.index'))
Gallery 
@elseif(Route::is('admin.image_gallery.create'))
Create New Gallery
@elseif(Route::is('admin.image_gallery.edit'))
Edit Gallery {{ $gallery->title }}
@elseif(Route::is('admin.image_gallery.show'))
View Gallery {{ $gallery->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
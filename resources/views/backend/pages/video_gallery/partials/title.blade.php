@if (Route::is('admin.video_gallery.index'))
Video Gallery 
@elseif(Route::is('admin.video_gallery.create'))
Create New Video Gallery
@elseif(Route::is('admin.video_gallery.edit'))
Edit Video Gallery {{ $gallery->title }}
@elseif(Route::is('admin.video_gallery.show'))
View Video Gallery {{ $gallery->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
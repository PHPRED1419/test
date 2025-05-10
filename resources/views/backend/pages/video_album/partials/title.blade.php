@if (Route::is('admin.video_album.index'))
Video Albums 
@elseif(Route::is('admin.video_album.create'))
Create New Video Album
@elseif(Route::is('admin.video_album.edit'))
Edit Video Album {{ $category->category_name }}
@elseif(Route::is('admin.brands.show'))
View Video Album {{ $category->category_name }}
@endif
| Admin Panel - 
{{ config('app.name') }}
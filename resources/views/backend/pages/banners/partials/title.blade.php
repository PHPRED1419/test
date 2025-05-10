@if (Route::is('admin.banners.index'))
Banners 
@elseif(Route::is('admin.banners.create'))
Create New Banner
@elseif(Route::is('admin.banners.edit'))
Edit Banner {{ $banner->banner_position }}
@elseif(Route::is('admin.banners.show'))
View Brand {{ $banner->banner_position }}
@endif
| Admin Panel - 
{{ config('app.name') }}
@if (Route::is('admin.flashes.index'))
Flash Banners 
@elseif(Route::is('admin.flashes.create'))
Create New Flash Banner
@elseif(Route::is('admin.flashes.edit'))
Edit Flash Banner {{ $flashe->flash_title }}
@elseif(Route::is('admin.flashes.show'))
View Flash Banner {{ $flashe->flash_title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
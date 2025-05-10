@if (Route::is('admin.sizes.index'))
Colors 
@elseif(Route::is('admin.sizes.create'))
Create New Color
@elseif(Route::is('admin.sizes.edit'))
Edit Color {{ $color->title }}
@elseif(Route::is('admin.colors.show'))
View Color {{ $colors->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
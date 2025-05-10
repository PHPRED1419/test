@if (Route::is('admin.parts.index'))
Models 
@elseif(Route::is('admin.parts.create'))
Create New Model
@elseif(Route::is('admin.parts.edit'))
Edit Model {{ $size->title }}
@elseif(Route::is('admin.parts.show'))
View Model {{ $parts->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
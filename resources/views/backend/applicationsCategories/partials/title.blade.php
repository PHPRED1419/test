@if (Route::is('admin.applicationsCategories.index'))
Application Categories
@elseif(Route::is('admin.applicationsCategories.create'))
Create New Application Category
@elseif(Route::is('admin.applicationsCategories.edit'))
Edit Application Category - {{ $applicationsCategories->name }}
@elseif(Route::is('admin.applicationsCategories.trashed'))
Trashed Application Categories
@endif
| Admin Panel -
{{ config('app.name') }}

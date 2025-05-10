@if (Route::is('admin.applicationsCategories.index'))
Application Categories
@elseif(Route::is('admin.applicationsCategories.create'))
Create New Category
@elseif(Route::is('admin.applicationsCategories.edit'))
Edit Category - {{ $applicationsCategories->name }}
@elseif(Route::is('admin.applicationsCategories.trashed'))
Trashed Categories
@endif
| Admin Panel -
{{ config('app.name') }}

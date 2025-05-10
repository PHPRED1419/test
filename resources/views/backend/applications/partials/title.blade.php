@if (Route::is('admin.applications.index'))
Applications
@elseif(Route::is('admin.applications.create'))
Create New Application
@elseif(Route::is('admin.applications.edit'))
Edit Application - {{ $application->application_name }}
@elseif(Route::is('admin.applications.trashed'))
Trashed Applications
@endif
| Admin Panel -
{{ config('app.name') }}

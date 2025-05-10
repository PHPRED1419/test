@if (Route::is('admin.keywords.index'))
keywords 
@elseif(Route::is('admin.keywords.create'))
Create New keywords
@elseif(Route::is('admin.keywords.edit'))
Edit keywords {{ $keywords->title }}
@elseif(Route::is('admin.keywords.show'))
View keywords {{ $keywords->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
@if (Route::is('admin.pages.index'))
Static Pages 
@elseif(Route::is('admin.pages.edit'))
Edit Page {{ $page->title }}
@elseif(Route::is('admin.pages.show'))
View Page {{ $pages->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
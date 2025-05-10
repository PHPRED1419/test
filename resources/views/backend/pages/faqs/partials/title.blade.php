@if (Route::is('admin.faqs.index'))
Faq's 
@elseif(Route::is('admin.faqs.create'))
Create New Faq
@elseif(Route::is('admin.faqs.edit'))
Edit Faq {{ $faq->title }}
@elseif(Route::is('admin.faqs.show'))
View Faq {{ $faq->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
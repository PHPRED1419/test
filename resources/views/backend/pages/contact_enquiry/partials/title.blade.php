@if (Route::is('admin.contact_enquiry.index'))
Product Enquiry
@elseif (Route::is('admin.contact_enquiry.show'))
View Enquiry
@endif
| Admin Panel -
{{ config('app.name') }}

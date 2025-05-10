@if (Route::is('admin.product_enquiry.index'))
Product Enquiry
@elseif (Route::is('admin.product_enquiry.show'))
View Enquiry
@endif
| Admin Panel -
{{ config('app.name') }}

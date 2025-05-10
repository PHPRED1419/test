@if (Route::is('admin.instant_offer_enquiry.index'))
Instant Offer Enquiry
@elseif (Route::is('admin.instant_offer_enquiry.show'))
View Enquiry
@endif
| Admin Panel -
{{ config('app.name') }}

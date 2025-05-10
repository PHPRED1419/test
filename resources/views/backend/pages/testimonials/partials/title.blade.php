@if (Route::is('admin.testimonials.index'))
Testimonials 
@elseif(Route::is('admin.testimonials.create'))
Post Testimonial
@elseif(Route::is('admin.testimonials.edit'))
Edit Testimonial {{ $testimonial->title }}
@elseif(Route::is('admin.testimonials.show'))
View Testimonial {{ $testimonial->title }}
@endif
| Admin Panel - 
{{ config('app.name') }}
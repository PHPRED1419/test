@component('mail::message')
# New Product Enquiry

**Product:** {{ $product->product_name }}  
**Name:** {{ $enquiry['name'] }}  
**Email:** {{ $enquiry['email'] }}  
**Phone:** {{ $enquiry['phone'] }}  

**Message:**  
{{ $enquiry['message'] }}

@component('mail::button', ['url' => route('products.details', $product->slug)])
View Product
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
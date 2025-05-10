@php
$flash_banner = getFlashBanner();
@endphp

<!--Header end-->
@if($flash_banner->isNotEmpty())
<!--Banner-->
<div class="banner-area">
<div class="fluid_container">

<div class="fluid_dg_wrap fluid_dg_charcoal_skin fluid_container banner" id="fluid_dg_wrap_1">
@foreach($flash_banner as $val)  
<div data-src="{{ asset('assets/images/flashes/' . $val->flash_image) }}">
<div class="fluid_dg_caption fadeIn position-relative">
<div class="hm_contact p-3 rounded-4 d-flex justify-content-between align-items-center clearfix">
<h2>{{  $val->flash_title }}</h2>

<span class="d-inline-block text-uppercase fw-semibold cont-btn">
<a href="{{ URL::to('/contact-us') }}" title="Contact Us" class="rounded-5">Contact Us <i><img src="{{ asset('assets/frontend/images/up-right-arrow.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="30" height="30"></i></a></span>
</div>

</div>
</div>
@endforeach
</div></div>

<div class="clearfix"></div>
</div>
<!--Banner end-->
@else
<div class="banner-area">
<div class="fluid_container">

<div class="fluid_dg_wrap fluid_dg_charcoal_skin fluid_container banner" id="fluid_dg_wrap_1">
<div data-src="{{ asset('assets/frontend/banner/slide1.jpg') }}">
<div class="fluid_dg_caption fadeIn position-relative">
<div class="hm_contact p-3 rounded-4 d-flex justify-content-between align-items-center clearfix">
<h2>{{  $val->flash_title }}</h2>

<span class="d-inline-block text-uppercase fw-semibold cont-btn">
<a href="{{ URL::to('/contact-us') }}" title="Contact Us" class="rounded-5">Contact Us <i><img src="{{ asset('assets/frontend/images/up-right-arrow.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="30" height="30"></i></a></span>
</div></div>
</div>
</div></div>
<div class="clearfix"></div>
</div>
@endif


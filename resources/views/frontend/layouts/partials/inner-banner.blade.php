@php
$inner_banner = getInnerBanner();
@endphp

<!--Header end-->
@if(!empty($inner_banner))
<!--Banner-->
<div class="inner_bnr"> 
<img src="{{ asset('assets/images/banners/' . $inner_banner) }}" class="" alt="" loading="lazy" fetchpriority="low" decoding="async">
</div>
<!--Banner end-->
@endif


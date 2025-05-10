@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | {{ config('app.description') }}
@endsection
@section('main-content')
@include('frontend.layouts.partials.flash-banner')
<!--Exporter-Portable-Section-->
<div class="container-xxl position-relative pt-4 pb-4">
<div class="hm_contact p-3 rounded-4 d-flex justify-content-between align-items-center clearfix">
<h2>Manufacturer &amp; Exporter Portable Oxygen Plant</h2>

<span class="d-block text-uppercase fw-semibold">
<a href="{{ URL::to('/contact-us') }}" title="Contact Us" class="rounded-5">Contact Us <i><img src="{{ asset('assets/frontend/images/up-right-arrow.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="30" height="30"></i></a></span>
</div>
<div class="clearfix"></div>

</div>
<!--Exporter-Portable-Section-->

<!--Welcome-Section-->

{!! $home_page_contents['description'] !!}

<!--Welcome-Section-End-->

@if(!empty($products))
<section class="product_section pt-3 pb-3 pt-lg-5 pb-lg-5 mt-4">
<div class="container-xxl">
<div class="hm_heading text-center">
<h2 class="heading  vollkorn">We Provide Excellent Products</h2>
</div>

<div id="pro_scroll"  class="owl-carousel owl-theme mt-3 scroll_arr2">
@foreach($products as $row)
<div class="item">
    <div class="pro_box position-relative overflow-hidden trans">
            <div class="col">
            <div class="pro_box position-relative overflow-hidden trans">
            <div class="pro_pic overflow-hidden text-center rounded-4">
            <figure class="d-table-cell align-middle text-center">
            <a href="{{ url('products/details/' . $row->slug) }}" title="{{ $row->product_name  }}">
            @if($row->media != "")
            {!! displayImage('assets/images/products/' . $row->media, $row->product_name, 'width:673px;height:438px;') !!}  

            @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="673" height="438">
            @endif      
            </a></figure>
            </div>    

             <?php /*{!! displayImage('assets/images/products/' . $row->media, $row->product_name, 'width:673px;height:438px;') !!} */ ?>       

            <div class="pro_cont position-relative  p-3 p-md-4 bg-white rounded-4">
            <p class="pro_name overflow-hidden fw-semibold vollkorn"><a href="{{ url('products/details/' . $row->slug) }}" title="">{{ $row->product_name }}</a></p>
            <p class="pro_txt overflow-hidden fw-medium mt-2 pt-2 position-relative">
            {!! char_limiter($row->products_description,200,'..') !!}
            </p>
            <div class="mt-3 specfy overflow-hidden">
            <h4 class="fw-bold text-uppercase Inter mb-2">Specification</h4>
            {!! char_limiter($row->products_specification,300,'..') !!}
            </div>
            <div class="mt-3">
            <a href="{{ url('products/details/' . $row->slug) }}" class="btn btn-info rounded-5">Get Price Now!</a>
            <a href="{{ url('products/details/' . $row->slug) }}" class="btn btn-text rounded-5">Technical Details</a>
            </div>
            </div>
            </div>
        </div>
     </div>
</div>
@endforeach
</div>

<div class="mt-2 mt-md-4 v_more text-center">
<a href="{{ url('products/') }}" class="btn more_btn rounded-5 fw-semibold" title="View More Products">View More Products </a> </div>
</div>

</div>
</section>
@endif


@if(!empty($applications))
<section class="application_section pt-3 pb-3 pt-lg-5 pb-lg-5">
<div class="container-xxl">
<div class="hm_heading text-center">
<h2 class="heading  vollkorn">Our Applications</h2>
</div>

<div id="appli_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2">
@foreach($applications as $row)
<div class="item">
    <div class="appli_w rounded-4 overflow-hidden position-relative m-auto mt-3">
            <div class="appli_img overflow-hidden rounded-4">
            <figure class="d-table-cell align-middle text-center">
            <a href="{{ url('aproducts/details/' . $row->slug) }}"><img src="{{ asset('assets/images/applications/' . $row->media) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="410" height="470"></a>
            </figure></div>

            <div class="appli_view position-absolute pb-4">
            <div class="appli_cont p-3">
            <div class="appli_name fw-semibold vollkorn overflow-hidden position-relative">
            <a href="{{ url('aproducts/details/' . $row->slug) }}">{{ $row->application_name }}</a></div>
            <div class="mt-3">
            <a href="{{ url('aproducts/details/' . $row->slug) }}" title="Read More" class="pro_more_btn rounded-4">Read More <i class="rounded-circle ms-3"><img src="{{ asset('assets/frontend/images/arrow_right.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="30" height="30"></i></a></div>
            </div></div>
    </div>
</div>
@endforeach

</div>

<div class="mt-2 mt-md-4 v_more text-center">
<a href="{{ url('aproducts/') }}" class="btn more_btn rounded-5 fw-semibold" title="View More Applications">View More Applications </a> </div>
</div>
</section>
@endif


<section class="gallery_section pt-3 pb-3 pt-lg-5 pb-lg-5">
<div class="container-xxl">
<div class="hm_heading d-flex justify-content-between">
<h2 class="heading vollkorn">Our successful project 
initiatives</h2>


<span class="hm_tabs vollkorn">
<a href="#tb1" title="Image Gallery" class="tabs active">Image Gallery</a> 
<a href="#tb2" title="Video Gallery"  class="tabs">Video Gallery</a></span>
</div>

<div id="tb1" class="form_box" style="display:block">
<div class="sub_tabs text-center mb-2 fw-semibold">
<a href="javascript:void()" class="act">ALL</a> <span>/</span>  
<a href="javascript:void()">Client Visits to Company</a>  <span>/</span>    
<a href="javascript:void()">Overseas Plant Setups</a>  <span>/</span>    
<a href="javascript:void()">Client Testimonial Certificates</a> 
</div>

<div id="gal_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2">
@if(!empty($gallery))
    @foreach($gallery as $row)
<div class="item">
<div class="ph_gal_w position-relative mt-3 m-auto">
        <div class="view_img vollkorn">
        <a href="{{ asset('assets/images/image_gallery/' . $row->photo) }}" data-fancybox="gallery" title=""><img src="{{ asset('assets/frontend/images/expend.svg') }}" alt="" decoding="async" width="20" height="20" fetchpriority="low" loading="lazy" class="me-2">Expand</a>
        </div>
        <div class="ph_gal rounded-4 overflow-hidden">
        <figure class="d-table-cell align-middle text-center">
        <img src="{{ asset('assets/images/image_gallery/' . $row->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
        </figure></div>
        <div class="gal_ttl text-center">{{ $row->title }}</div>
        </div></div>
@endforeach
@endif
</div>

<div class="mt-2 mt-md-4 v_more text-center">
<a href="{{ URL::to('/image-album') }}" class="btn more_btn rounded-5 fw-semibold" title="View More Applications">View More Gallery</a> </div>

</div>

<div id="tb2" class="form_box" style="display:none">
<div class="sub_tabs text-center mb-2 fw-semibold">
<a href="javascript:void()" class="act">ALL</a> <span>/</span>  
<a href="javascript:void()">Client Visits to Company</a>  <span>/</span>    
<a href="javascript:void()">Overseas Plant Setups</a>  <span>/</span>    
<a href="javascript:void()">Client Testimonial Certificates</a> 
</div>

<div id="gal_scroll2" class="owl-carousel owl-theme mt-3 scroll_arr2">
@if(!empty($vgallery))
    @foreach($vgallery as $vrow)
<div class="item">
<div class="video_bx position-relative mt-3 m-auto">
        <div class="play_btn text-center d-flex align-items-center justify-content-center position-absolute rounded-4">
        <a href="{{  $vrow->youtube_link }}" data-fancybox="gal"><b class="rounded-3"><img src="{{ asset('assets/frontend/images/play.svg') }}" decoding="async" fetchpriority="low" loading="lazy" alt="" width="24" height="24"></b></a></div>
        <div class="video_img  rounded-4 overflow-hidden">
        <img src="{{ asset('assets/images/video_gallery/' . $vrow->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
        </div>
        <div class="gal_ttl text-center">{{ $vrow->title }}</div>
        </div></div>
@endforeach
@endif

</div>

<div class="mt-2 mt-md-4 v_more text-center">
<a href="{{ URL::to('/video-album') }}" class="btn more_btn rounded-5 fw-semibold" title="View More Applications">View More Gallery</a> </div>

</div>
</div>
</section>


@endsection

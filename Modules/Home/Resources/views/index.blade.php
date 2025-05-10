@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | {{ config('app.description') }}
@endsection
@section('main-content')
@include('frontend.layouts.partials.flash-banner')
<!--Exporter-Portable-Section-->
<?php /*?><div class="container-xxl position-relative pt-4 pb-4">
<div class="hm_contact p-3 rounded-4 d-flex justify-content-between align-items-center clearfix">
<h2>Manufacturer &amp; Exporter Portable Oxygen Plant</h2>

<span class="d-block text-uppercase fw-semibold">
<a href="{{ URL::to('/contact-us') }}" title="Contact Us" class="rounded-5">Contact Us <i><img src="{{ asset('assets/frontend/images/up-right-arrow.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="30" height="30"></i></a></span>
</div>
<div class="clearfix"></div>

</div><?php */?>
<!--Exporter-Portable-Section-->

<!--Welcome-Section-->

{!! $home_page_contents['description'] !!}

<!--Welcome-Section-End-->

@if(!empty($products))
<section class="product_section pt-3 pb-3 pt-lg-5 pb-lg-5 mt-4">
<div class="container-xxl">
<div class="hm_heading text-center">
<h2 class="heading  vollkorn">Industrial & Medical Oxygen Nitrogen Plants</h2>
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
            <img src="{{ asset('assets/images/products/' . $row->media) }}" loading="lazy" fetchpriority="low" decoding="async" alt="{{ $row->product_name }}" style="width: 673px;height: 438px;">
            @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 673px;height: 462px;">
            @endif 

           <?php
           /* @if($row->media != "")
            {!! displayImage('assets/images/products/' . $row->media, $row->product_name, 'width:673px;height:438px;') !!}  

            @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="673" height="438">
            @endif 
            */
            ?>     
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
<h2 class="heading  vollkorn">Industrial Applications</h2>
</div>

<div id="appli_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2">
@foreach($applications as $row)
<div class="item">
    <div class="appli_w rounded-4 overflow-hidden position-relative m-auto mt-3">
            <div class="appli_img overflow-hidden rounded-4">
            <figure class="d-table-cell align-middle text-center">
            <a href="{{ url('aproducts/details/' . $row->slug) }}">            
            @if($row->media != "")
                <img src="{{ asset('assets/images/applications/' . $row->media) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="410" height="470">
            @else
                <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 410px;height: 470px;">
            @endif 
            </a>
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


@php
use App\Models\VideoGallery; 
use App\Models\ImageGallery;
@endphp


<section class="gallery_section pt-3 pb-3 pt-lg-5 pb-lg-5">
<div class="container-xxl">
<div class="hm_heading d-flex justify-content-between">
<h2 class="vollkorn">UNIVERSAL BOSCHI PROJECT INSTALLATIONS<br /> WORLDWIDE</h2>


<span class="hm_tabs vollkorn">
<a href="#tb1" title="Image Gallery" class="tabs">Image Gallery</a> 
<a href="#tb2" title="Video Gallery"  class="tabs active">Video Gallery</a></span>
</div>

<div id="tb1" class="form_box" style="display:none">
<div class="sub_tabs text-center mb-2 fw-semibold sm_tabs">
<a href="#sm_tb1" class="act">ALL</a> <span>/</span> 
@if(!empty($image_album))
    @foreach($image_album as $index => $val)
        @php $displayIndex = $index + 2; @endphp
        <a href="#sm_tb{{ $displayIndex }}">{{ $val->category_name }}</a>
        @if($index < count($image_album) - 1)
            <span>/</span>
        @endif
    @endforeach
@endif 
</div>

<div id="sm_tb1" class="tab_box">
<div id="gal_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2 owl-loaded owl-drag">
@php
$query = ImageGallery::query()
    ->where('status', 1)
    ->orderBy('created_at', 'desc');        
$igallery = $query->paginate(12);
@endphp

@if(!empty($igallery))
    @foreach($igallery as $val2)
<div class="item">
    <div class="ph_gal_w position-relative mt-3 m-auto">
        <div class="view_img vollkorn">
        <a href="{{ asset('assets/images/image_gallery/' . $val2->photo) }}" data-fancybox="gallery" title=""><img src="{{ asset('assets/frontend/images/expend.svg') }}" alt="" decoding="async" width="20" height="20" fetchpriority="low" loading="lazy" class="me-2">Expand</a>
        </div>
        <div class="ph_gal rounded-4 overflow-hidden">
        <figure class="d-table-cell align-middle text-center">
        <img src="{{ asset('assets/images/image_gallery/' . $val2->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
        </figure></div>
        <div class="gal_ttl text-center">{{ $val2->title }}</div>
        </div>
    </div>
@endforeach
@endif 

</div>
</div>
@if(!empty($image_album))
    @foreach($image_album as $index => $val)
        @php $displayIndex = $index + 2; @endphp
        <div id="sm_tb{{ $displayIndex }}" class="tab_box" style="display: none;">
            <div id="gal_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2 owl-loaded owl-drag">
                @php
                $query = ImageGallery::query()
                    ->where('category_id', $val->category_id)
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc');        
                $igallery = $query->paginate(12); 
                @endphp

                @if(!empty($igallery))
                    @foreach($igallery as $val2)
                        <div class="item">
                          <div class="ph_gal_w position-relative mt-3 m-auto">
                            <div class="view_img vollkorn">
                            <a href="{{ asset('assets/images/image_gallery/' . $val2->photo) }}" data-fancybox="gallery" title=""><img src="{{ asset('assets/frontend/images/expend.svg') }}" alt="" decoding="async" width="20" height="20" fetchpriority="low" loading="lazy" class="me-2">Expand</a>
                            </div>
                            <div class="ph_gal rounded-4 overflow-hidden">
                            <figure class="d-table-cell align-middle text-center">
                            <img src="{{ asset('assets/images/image_gallery/' . $val2->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
                            </figure></div>
                            <div class="gal_ttl text-center">{{ $val2->title }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif


<div class="mt-2 mt-md-4 v_more text-center">
<a href="{{ URL::to('/image-album') }}" class="btn more_btn rounded-5 fw-semibold" title="View More Applications">View More Gallery</a> </div>
</div>

<div id="tb2" class="form_box">
<div class="sub_tabs text-center mb-2 fw-semibold vd_tabs">
<a href="#vd_tb1" class="act">ALL</a> <span>/</span> 
@if(!empty($video_album))
    @foreach($video_album as $index => $val)
        @php $displayIndex = $index + 2; @endphp
        <a href="#vd_tb{{ $displayIndex }}">{{ $val->category_name }}</a>
        @if($index < count($video_album) - 1)
            <span>/</span>
        @endif
    @endforeach
@endif

</div>

<div id="vd_tb1" class="vd_box">
<div id="vd_gal_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2">
@php
$query = VideoGallery::query()
    ->where('status', 1)
    ->orderBy('created_at', 'desc');        
$vgallery = $query->paginate(12);
@endphp

@if(!empty($vgallery))
    @foreach($vgallery as $val2)
    <div class="item">
        <div class="video_bx position-relative mt-3 m-auto">
        <div class="play_btn text-center d-flex align-items-center justify-content-center position-absolute rounded-4">
        <a href="{{  $val2->youtube_link }}" data-fancybox="gal"><b class="rounded-3"><img src="{{ asset('assets/frontend/images/play.svg') }}" decoding="async" fetchpriority="low" loading="lazy" alt="" width="24" height="24"></b></a></div>
        <div class="video_img  rounded-4 overflow-hidden">
        <img src="{{ asset('assets/images/video_gallery/' . $val2->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
        </div>
        <div class="gal_ttl text-center">{{ $val2->title }}</div>
        </div>
    </div>
    @endforeach
@endif
</div>
</div>
@if(!empty($video_album))
    @foreach($video_album as $index => $val)
        @php $displayIndex = $index + 2; @endphp
        <div id="vd_tb{{ $displayIndex }}" class="vd_box" style="display: none;">
            <div id="vd_gal_scroll" class="owl-carousel owl-theme mt-3 scroll_arr2 owl-loaded owl-drag">            
                @php
                $query = VideoGallery::query()
                    ->where('category_id', $val->category_id)
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc');        
                $vgallery = $query->paginate(12); 
                @endphp

                @if(!empty($vgallery))
                    @foreach($vgallery as $val2)
                        <div class="item">
                            <div class="video_bx position-relative mt-3 m-auto">
                            <div class="play_btn text-center d-flex align-items-center justify-content-center position-absolute rounded-4">
                            <a href="{{  $val2->youtube_link }}" data-fancybox="gal"><b class="rounded-3"><img src="{{ asset('assets/frontend/images/play.svg') }}" decoding="async" fetchpriority="low" loading="lazy" alt="" width="24" height="24"></b></a></div>
                            <div class="video_img  rounded-4 overflow-hidden">
                            <img src="{{ asset('assets/images/video_gallery/' . $val2->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
                            </div>
                            <div class="gal_ttl text-center">{{ $val2->title }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif


<div class="mt-2 mt-md-4 v_more text-center">
<a href="{{ URL::to('/video-album') }}" class="btn more_btn rounded-5 fw-semibold" title="View More Applications">View More Gallery</a> </div>

</div>
</div>
</section>
@push('home_styles')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fluid_dg.css') }}">
@endpush
@endsection


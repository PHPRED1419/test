@extends('frontend.layouts.master')

@section('title', $product->meta_title ?? $product->name)
@section('description', $product->meta_description ?? str_limit($product->description, 160))

@section('main-content')
@include('frontend.layouts.partials.inner-banner')
<?php 
if(isset($product->category_id) && $product->product_type!='2'){	
	//echo generateCategoryBreadcrumbs($product->category_id,$separator = ' &raquo; ', $activeClass = 'active',$product->product_name);
	echo category_breadcrumbs($product->category_id,$product->parent_category_id,$product->product_name);
}else{
	?>
<nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a></li>
@if($product->product_type==2)
<li class="breadcrumb-item"><a href="{{ URL::to('/services')  }}">Services</a></li>
@endif
<li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
</ol>
</div>
</nav>
<?php }?>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<div class="row">
<div class="col-12 col-lg-6">
<div class="pc_box mb-3 shadow border">
<div class="dtl_pic overflow-hidden m-auto  mt-2 mt-lg-3">
<figure class="d-table-cell align-middle text-center m-0">
@if($product->media != "")
    <a href="{{ asset('assets/images/products/' . $product->media) }}" class="MagicZoomPlus" id="Zoomer" title="" data-options="zoomMode:magnifier;"><img src="{{ asset('assets/images/products/' . $product->media) }}" alt="" loading="lazy" fetchpriority="low" decoding="async"></a>
@else
    <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 673px;height: 438px;">
@endif    
</figure></div>
@if(!empty($media)) 
<div class="thm_img mt-2">
<div id="owl-details" class="owl-carousel owl-theme scroll_arr2">
@foreach($media as $v)
    <div class="item">
        <div class="ds_thm overflow-hidden m-auto mt-2 mb-2"><figure class="d-table-cell align-middle text-center m-0"><a href="{{ asset('assets/images/products/' . $v->media) }}"  data-zoom-id="Zoomer" data-image="{{ asset('assets/images/products/' . $v->media) }}"><img src="{{ asset('assets/images/products/' . $v->media) }}" alt="" loading="lazy" fetchpriority="low" decoding="async"></a></figure> </div>
    </div>
@endforeach
</div>
</div>
@endif
<div class="clearfix"></div>

</div>
</div>

<div class="col-12 col-lg-6">
<div class="dtl_right mt-3 mt-md-0">
<h2 class="dtl_title fw-bold ">{{ $product->product_name  }}</h2>
 <p>Product Code: {{ $product->product_code  }}</p>

<div class="share_w d-block mt-2 ">
<b Class="fw-semibold d-block exo">Share On:</b> 
<button class="share-to btn btn_fb" data-with="facebook">
<img src="{{ asset('assets/frontend/images/icon_fb.svg') }}" alt="Facebook" title="facebook"  width="18" height="18" loading="lazy" fetchpriority="low" decoding="async"> </button>

<button class="share-to btn btn_tw" data-with="twitter">
<img src="{{ asset('assets/frontend/images/icon_tw.svg') }}" alt="twitter" title="Twitter"  width="18" height="18" loading="lazy" fetchpriority="low" decoding="async"> </button>

<button class="share-to btn btn_in" data-with="linkedin">
<img src="{{ asset('assets/frontend/images/icon_in.svg') }}" alt="Linkedin" title="Linkedin"  width="18" height="18" loading="lazy" fetchpriority="low" decoding="async"> </button>

<button class="share-to btn btn_pint" data-with="pinterest">
<img src="{{ asset('assets/frontend/images/icon_pinterest.svg') }}" alt="Pinterest" title="Pinterest"  width="18" height="18" loading="lazy" fetchpriority="low" decoding="async"> </button>
</div>

@if(session('success'))
    <div class="alert alert-success" style="font-size: 23px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="font-size: 23px;">
        {{ session('error') }}
    </div>
@endif
<div class="enquiry_form mt-3 bg-white rounded-3 shadow-lg">

    <form method="POST" action="{{ route('products.enquiry.submit') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->products_id }}">
        
        <div class="row">
            <div class="col-sm-12 mb-2">
                <input type="text" class="form-control" value="{{ $product->product_name }}" disabled>
            </div>

            <div class="col-sm-12 mb-2">
                <input type="text" name="name" class="form-control" placeholder="Full Name *"  value="{{ old('name') }}">
                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-12 mb-2">
                <input type="email" name="email" class="form-control" placeholder="Email ID *"  value="{{ old('email') }}">
                @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-12 mb-2">
                <input type="text" name="phone" class="form-control" placeholder="Phone Number *"  value="{{ old('phone') }}">
                @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-12 mb-2">
                <textarea class="form-control" name="message" rows="3" placeholder="Comment/Enquiry *">{{ old('message') }}</textarea>
                @error('message')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
        <?php
        /*
            <div class="col-sm-12 mb-2">
                <div class="form-field captcha_t">
                    <input type="text" class="form-control me-2" name="captcha" placeholder="Enter Code *" required>
                    <img src="{{ captcha_src() }}" alt="Captcha" class="vam"> 
                    <a href="#" class="ms-2" onclick="refreshCaptcha()">
                        <img src="{{ asset('images/ref2.svg') }}" alt="Refresh" width="22" class="vam">
                    </a>
                    @error('captcha')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>
        */
        ?>
            <div class="col-12 text-uppercase">
                <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-semibold">Send Enquiry</button>
            </div>
        </div>
    </form>
</div>


</div>
</div>
</div>

@if(!empty($product->products_description))
<div class="detail_des_w mt-3 mt-md-5">
<h2 class="mb-2 fw-semibold exo">Description</h2>
<div class="tab_cont fw-medium">
{!! $product->products_description !!}
</div>
</div>
@endif

@if(!empty($product->products_specification))
<div class="detail_des_w mt-3 mt-md-5">
<h2 class=" mb-2 fw-semibold exo">Specification</h2>
<div class="tab_cont  fw-medium">
{!! $product->products_specification !!}
</div>
</div>
@endif

</div>
</div>
</div>


@push('scripts')
<script>
function refreshCaptcha() {
    event.preventDefault();
    document.querySelector('.captcha_t img').src = "{{ captcha_src() }}?" + Date.now();
}
</script>
@endpush

@endsection


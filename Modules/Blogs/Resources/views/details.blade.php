@extends('frontend.layouts.master')

@section('title', $blog->title ?? $blog->title)
@section('description', $blog->meta_description ?? str_limit($blog->description, 160))

@section('main-content')
@include('frontend.layouts.partials.inner-banner')
<nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ URL::to('/blogCategory')  }}">Blog Category</a></li>
<li class="breadcrumb-item"><a href="{{ URL::to('/blogs')  }}">Blogs</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $blog->title  }}</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<div class="row">
<div class="col-12 col-lg-4 order-lg-2">
<div class="blog_box_cate bg-white shadow border border-secondary  border-opacity-25 p-3 rounded-3 mb-4">
<h2 class="fs-5 fw-semibold text-dark text-uppercase d-none d-lg-block mb-3">Categories</h2>
<h2 class="fs-5 fw-semibold text-dark text-uppercase d-block d-lg-none shownext"> <img src="{{ asset('assets/frontend/images/menu.svg') }}" loading="lazy" width="22" height="22" alt="" class="align-middle me-2"> Categories</h2>
@if(!empty($categories)) 
<ul class="blog_cate_list tab_hid mt-3 ms-0 m-lg-0 p-0">
    @foreach($categories as $val)
        <li><a href="{{ url('blogs/' . $val['slug']) }}">{{ $val['category_name'] }}</a></li>
    @endforeach
</ul>
@endif
</div>

</div>
<div class="col-12 col-lg-8">
<div class="blog_detail">
<p class="blog_cate_name d-inline-block rounded-5">{{ $category_name  }}</p> 
<div class="fs-4  fw-semibold mt-3  vollkorn text-dark">{{ $blog->title }}</div>

<div class="d-flex flex-wrap justify-content-between align-items-center">
<div class="posted_by mt-3 rounded-5">
<span class="d-inline-block border-end border-dark border-opacity-10">
    <img src="{{ asset('assets/frontend/images/user.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="20" height="20" class="me-1 align-middle"> By:Admin</span>

<span class="d-inline-block"><img src="{{ asset('assets/frontend/images/calendar2.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="20" height="20" class="me-1  align-middle">{{ $blog->created_at->format('d M Y') }}</span>
</div>

<div class="share_w  mt-3">
<b Class="fw-semibold d-inline-block">Share On:</b> 
<button class="share-to btn btn_fb" data-with="facebook" data-url="{{ $settings->social->facebook }}">
<img src="{{ asset('assets/frontend/images/icon_fb.svg') }}" width="19" height="19" title="Facebook" alt="" decoding="async" fetchpriority="low" loading="lazy"> </button>

<button class="share-to btn btn_tw" data-with="twitter" data-url="{{ $settings->social->twitter }}">
<img src="{{ asset('assets/frontend/images/icon_tw.svg') }}" width="19" height="19" title="Twitter" alt="" decoding="async" fetchpriority="low" loading="lazy"> </button>

<button class="share-to btn btn_in" data-with="linkedin" data-url="{{ $settings->social->linkedin }}">
<img src="{{ asset('assets/frontend/images/icon_in.svg') }}" width="19" height="19" title="Linkedin In" alt="" decoding="async" fetchpriority="low" loading="lazy"> </button>

<button class="share-to btn btn_insta" data-with="instagram" data-url="{{ $settings->social->instagram }}">
<img src="{{ asset('assets/frontend/images/icon_insta.svg') }}" width="19" height="19" title="Instagram" alt="" decoding="async" fetchpriority="low" loading="lazy"> </button>

<button class="share-to btn btn_whts" data-with="pinterest" data-url="{{ $settings->social->pinterest }}">
<img src="{{ asset('assets/frontend/images/icon_pinterest.svg') }}" width="19" height="19" title="Pinterest" alt="" decoding="async" fetchpriority="low" loading="lazy"> </button>
</div>

</div>


<div id="blog_img_scroll" class="owl-carousel owl-theme mt-3 owl-loaded owl-drag">
    @php
        $images = array_filter([
            $blog->image,
            $blog->image2,
            $blog->image3,
            $blog->image4
        ]);
    @endphp

    @if(count($images) > 0)
        @foreach($images as $image)
            <div class="item">
                <div class="blog_dtl_img overflow-hidden rounded-3 mt-3 m-auto">
                    <img src="{{ asset('assets/images/blogs/' . $image) }}" class="w-100" alt="{{ $blog->title }}" loading="lazy">
                </div>
            </div>
        @endforeach
    @else
        <div class="item">
            <div class="blog_dtl_img overflow-hidden rounded-3 mt-3 m-auto">
                <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="No image available" loading="lazy" style="width: 389px; height: 389px;">
            </div>
        </div>
    @endif
</div>

<div class="mt-4">{!! $blog->description !!}</div>
<br/><br/>
</div>
</div>

</div></div></div>

<div class="clearfix"></div>

@push('scripts')
<script>
function refreshCaptcha() {
    event.preventDefault();
    document.querySelector('.captcha_t img').src = "{{ captcha_src() }}?" + Date.now();
}
</script>
@endpush

<div class="clearfix"></div>
@endsection


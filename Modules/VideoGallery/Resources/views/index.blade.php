@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | {{ config('app.description') }}
@endsection
@section('main-content')
@include('frontend.layouts.partials.inner-banner')

<nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ URL::to('/video-album')  }}">Videoes Album</a></li>
<li class="breadcrumb-item">{{ $category_name }}</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Videoes Gallery </h1>
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-2 row-cols-xl-2 g-2 mb-3">
@if(!empty($gallery))
    @foreach($gallery as $row)
    <div class="col">
        <div class="video_bx position-relative mt-3 m-auto">
        <div class="play_btn text-center d-flex align-items-center justify-content-center position-absolute rounded-4">
        <a href="{{  $row->youtube_link }}" data-fancybox="gal"><b class="rounded-3"><img src="{{ asset('assets/frontend/images/play.svg') }}" decoding="async" fetchpriority="low" loading="lazy" alt="" width="24" height="24"></b></a></div>
        <div class="video_img  rounded-4 overflow-hidden">
        @if($row->photo != "")
            <img src="{{ asset('assets/images/video_gallery/' . $row->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
        @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 671px;height: 450px;">
        @endif
        
        </div>
        <div class="gal_ttl text-center">{{ $row->title }}</div>
        </div>
    </div>  
    @endforeach
@endif

</div>




</div>
</div>
</div>



<div class="clearfix"></div>

@endsection

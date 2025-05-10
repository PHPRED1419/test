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
<li class="breadcrumb-item">Images Albums</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Images Albums</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-2 row-cols-xl-3 g-2 cate_list">
@if(!empty($album))
    @foreach($album as $row)
    <div class="col">
        <div class="gal_cate_box position-relative m-auto">
        <div class="gal_cate_pic overflow-hidden text-center m-auto rounded-3">
        <figure class="d-table-cell align-middle text-center"><a href="{{ url('image-gallery/' . $row->slug) }}" title="{{ $row->category_name }}">        
        @if($row->category_image != "")
        <img src="{{ asset('assets/images/image_album/' . $row->category_image) }}" loading="lazy" fetchpriority="low" decoding="async" alt="{{ $row->category_name }}">
        @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 389px;height: 389px;">
        @endif  
        </a></figure></div>
        <div class="text-center">
        <p class="gal_cate_name overflow-hidden text-center fw-bold vollkorn"><a href="{{ url('image-gallery/' . $row->slug) }}" title="{{ $row->category_name }}">{{ $row->category_name }}</a>
        </p>
        </div>
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

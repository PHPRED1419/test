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
<li class="breadcrumb-item">Blog Category</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Blog Category</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-2 row-cols-xl-3 g-2 mb-3">
@if(!empty($categories))
    @foreach($categories as $row)
    <div class="col">
        <div class="blog_cate_box mt-4 m-auto shadow border border-dark rounded-3">
        <div class="blog_cate_img overflow-hidden text-center m-auto rounded-3"><figure class="d-table-cell align-middle text-center"><a href="{{ url('blogs/' . $row->slug) }}" title="">
        @if($row->category_image != "")
            <img src="{{ asset('assets/images/blogs_categories/' . $row->category_image) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="389" height="389">
        @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 389px;height: 389px;">
        @endif 
        </a></figure></div>

        <div class="blg_cate_cont p-2 text-center">
        <p class="blg_cate_name overflow-hidden fw-semibold text-center vollkorn">
        <a href="{{ url('blogs/' . $row->slug) }}">{{ $row->category_name }}</a></p>
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

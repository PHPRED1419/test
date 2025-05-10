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
<li class="breadcrumb-item"><a href="{{ URL::to('/blogCategory')  }}">Category</a></li>
<li class="breadcrumb-item">
@if(!empty($category_name))
{{ $category_name }}
@else
{{ 'Blogs' }}
@endif
</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Blogs</h1>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 mt-4">

@forelse($blogs as $row)
<div class="col">
    <div class="blog_w rounded-4 overflow-hidden position-relative m-auto mt-3">
    <div class="blog_img overflow-hidden rounded-4">
    <figure class="d-table-cell align-middle text-center">
    <a href="{{ url('blogs/details/' . $row->slug) }}">
    @if($row->image != "")
        <img src="{{ asset('assets/images/blogs/' . $row->image) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="438" height="438">
    @else
        <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 389px;height: 389px;">
    @endif 
    </a>
    </figure></div>

    <div class="blog_view position-absolute pb-3">
    <div class="blog_cont p-3">
    <div class="blog_name fw-semibold vollkorn overflow-hidden position-relative">
    <a href="{{ url('blogs/details/' . $row->slug) }}">{{ $row->title }}</a></div>

    <div class="posted_by mt-3">
    <span class="d-inline-block"><img src="{{ asset('assets/frontend/images/user.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="22" height="22" class="me-1"> By:Admin</span>

    <span class="d-inline-block"><img src="{{ asset('assets/frontend/images/calendar2.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="22" height="22" class="me-1">{{ $row->created_at->format('d M Y') }}</span>
    </div>

    <div class="mt-3">
    <a href="{{ url('blogs/details/' . $row->slug) }}" title="Read More" class="pro_more_btn rounded-4">Read More <i class="rounded-circle ms-3"><img src="{{ asset('assets/frontend/images/arrow_right.svg') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="30" height="30"></i></a></div>
    </div>
    </div>
    </div>
</div>

@empty
    <div class="col-12 justify-content-center">
        <div class="alert alert-info text-center py-4">
            <h4>No Blog found</h4>
            <p>We couldn't find any Blog matching your criteria</p>
                {{-- <a href="URL::to('/')" class="btn btn-primary">Return to Home</a> --}}
        </div>
    </div>
@endforelse

</div>


</div></div></div>


<div class="clearfix"></div>

@endsection

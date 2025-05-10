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
<li class="breadcrumb-item"><a href="{{ URL::to('/acategory')  }}">Application Category</a></li>
<li class="breadcrumb-item">Application Products</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Applications </h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-0 mt-4">
        @forelse($products as $row)
            <div class="col">
                <div class="appli_w rounded-4 overflow-hidden position-relative m-auto mt-3">
                <div class="appli_img overflow-hidden rounded-4">
                <figure class="d-table-cell align-middle text-center">
                <a href="{{ url('aproducts/details/' . $row->slug) }}">
                @if($row->media != "")
                    <img src="{{ asset('assets/images/applications/' . $row->media) }}" loading="lazy" fetchpriority="low" decoding="async" width="410" height="470">
                @else
                    <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 389px;height: 389px;">
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
        @empty
        <div class="col-12 justify-content-center">
                <div class="alert alert-info text-center py-4">
                    <h4>No products found</h4>
                    <p>We couldn't find any products matching your criteria</p>
                     {{-- <a href="URL::to('/')" class="btn btn-primary">Return to Home</a> --}}
                </div>
            </div>
        @endforelse
</div>



</div>
</div>
</div>

<div class="clearfix"></div>

@endsection

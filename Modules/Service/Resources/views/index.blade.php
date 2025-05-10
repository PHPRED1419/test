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
<li class="breadcrumb-item">Services</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Services</h1>
<div class="service_list">
@forelse($services as $row)
<div class="pro_box position-relative overflow-hidden trans mt-3">
<div class="pro_pic overflow-hidden text-center rounded-4">
<figure class="d-table-cell align-middle text-center">
<a href="{{ url('products/details/' . $row->slug) }}" title="{{ $row->product_name  }}">
@if($row->media != "")
    <img src="{{ asset('assets/images/products/' . $row->media) }}" loading="lazy" fetchpriority="low" decoding="async" width="673" height="438">
@else
    <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 673px;height: 438px;">
@endif 
</a></figure></div>

<div class="pro_cont position-relative  p-3 p-md-4 bg-white rounded-4">
<p class="pro_name overflow-hidden fw-semibold vollkorn"><a href="{{ url('products/details/' . $row->slug) }}" title="{{ $row->product_name  }}">{{ $row->product_name  }}</a></p>
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
</div></div>
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

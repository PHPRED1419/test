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
<li class="breadcrumb-item"><a href="{{ URL::to('/image-album')  }}">Image Album</a></li>
<li class="breadcrumb-item">{{ $category_name }}</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Image Gallery </h1>
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-2 row-cols-xl-2 g-2 mb-3">
@forelse($gallery as $row)
    <div class="col">
        <div class="ph_gal_w position-relative mt-3 m-auto">
        @if($row->photo != "")
        <div class="view_img vollkorn">
        <a href="{{ asset('assets/images/image_gallery/' . $row->photo) }}" data-fancybox="gallery" title="">
        <img src="{{ asset('assets/frontend/images/expend.svg') }}" alt="" decoding="async" width="20" height="20" fetchpriority="low" loading="lazy" class="me-2">Expand</a>
        </div>
        @endif
        <div class="ph_gal rounded-4 overflow-hidden">
        <figure class="d-table-cell align-middle text-center">        
        @if($row->photo != "")
        <img src="{{ asset('assets/images/image_gallery/' . $row->photo) }}" alt="" loading="lazy" fetchpriority="low" decoding="async" width="671" height="450">
        @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 671px;height: 450px;">
        @endif
        </figure></div>
        <div class="gal_ttl text-center">{{ $row->title }}</div>
        </div>
    </div>   
@empty
    <div class="col-12 justify-content-center">
        <div class="alert alert-info text-center py-4">
            <h4>No records found</h4>
            <p>We couldn't find any records matching your criteria</p>
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

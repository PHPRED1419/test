@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | {{ config('app.description') }}
@endsection
@section('main-content')
@include('frontend.layouts.partials.inner-banner')

<?php 
if(isset($slug))
{		
	echo applicationCategoryBreadcrumbs($slug);
}?>

<?php /*?><nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a></li>
<li class="breadcrumb-item">Application Category</li>
</ol>
</div>
</nav><?php */?>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Application</h1>

<div class="row row-cols-2 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-2 cate_list">
@if(!empty($data))
    @foreach($data as $row)
        <div class="col">
        <div class="cate_box position-relative "> 
        <div class="cate_pic overflow-hidden text-center m-auto rounded-3">
        <figure class="d-table-cell align-middle text-center"><a href="{{ url('acategory/' . $row->slug) }}" title=" $row->name  }}">
        @if($row->category_image != "")
            <img src="{{ asset('assets/images/application_categories/' . $row->category_image) }}" loading="lazy" fetchpriority="low" decoding="async" width="283" height="283">
        @else
            <img src="{{ asset('assets/frontend/images/no_image.png') }}" alt="" loading="lazy" fetchpriority="low" decoding="async" style="width: 283px;height: 283px;">
        @endif
        </a></figure></div>
        <div class="text-center">
        <p class="cate_name overflow-hidden text-center fw-bold vollkorn"><a href="{{ url('acategory/' . $row->slug) }}" title="{{ $row->name }}">{{ $row->name }}</a></p>
        </div></div>
        </div>
    @endforeach
@endif

</div>




</div>
</div>
</div>



<div class="clearfix"></div>

@endsection

<!-- Navigation -->
<!--Header-->
@php
if(Request::segment(1) == 'home') {
    $header_cls = 'header_pos';
} elseif(Request::segment(1) == 'pages') {
    $header_cls = 'header_inner';
} else {
    $header_cls = 'header_inner';
}
@endphp

<header class="sticky_header">
<div class="{{ $header_cls }}">  
<div class="container-xxl">
<div class="row">
<div class="col-12 col-sm-5 col-md-3">
<div class="logo mt-3 mb-sm-3">    
    @if (!empty($settings->general->logo))
        <a href="{{ URL::to('/')  }}" title="{{ $settings->general->name }}"><img src="{{ asset('assets/images/logo/' . $settings->general->logo) }}" width="303" height="48" alt="{{ config('app.name') }}" fetchpriority="low" decoding="async" class="img-fluid" /></a>
    @endif   
 </div>
</div>
<div class="col-12 col-sm-7 col-md-9">
<div class="top_hed_rgt pt-2 pt-lg-4 mb-2 d-flex justify-content-end align-items-center">
<nav class="navbar navbar-expand-lg p-0 mb-1 me-1">
<div class="w-100">
<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
<div class="offcanvas-header">
<h5 class="offcanvas-title" id="offcanvasNavbar2Label">Navigation</h5>
<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body justify-content-between">
<ul class="navbar-nav m-0 exo">
<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" title="About Us">About Us <img src="{{ asset('assets/frontend/images/arrow_dwn.svg') }}" width="20" height="20" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></a>
<div class="dropdown-menu">
<ul class="m-0 p-0">
<li><a class="dropdown-item" href="{{ URL::to('/about-us')  }}" title="About Company">About Company</a></li>
<li><a class="dropdown-item" href="{{ URL::to('/vision-mission')  }}" title="Vision &amp; Mission">Vision &amp; Mission</a></li>
</ul>
</div>
</li>



@isset($category_data)
@if($category_data->isNotEmpty())
<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" title="Our Products">Our Products <img src="{{ asset('assets/frontend/images/arrow_dwn.svg') }}" width="20" height="20" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></a>
<div class="dropdown-menu">
<ul class="m-0 p-0">
@foreach($category_data as $category)
<li>
    <a class="dropdown-item" 
        href="{{ URL::to("category/{$category['slug']}") }}" title="{{ $category['name'] }}">{{ $category['name'] }} </a>
</li>
@endforeach
@if(count($category_data) > 4)
<li><a class="dropdown-item" href="{{ URL::to('/category') }}" title="View All">View All</a></li>
@endif
</ul>
</div>
</li>
@endif
@endisset



@isset($acategory_data)
@if($acategory_data->isNotEmpty())
<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" title="Applications">Applications <img src="{{ asset('assets/frontend/images/arrow_dwn.svg') }}" width="20" height="20" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></a>
<div class="dropdown-menu">
<ul class="m-0 p-0">
@foreach($acategory_data as $category)
<li>
    <a class="dropdown-item" 
        href="{{ URL::to("acategory/{$category['slug']}") }}" title="{{ $category['name'] }}">{{ $category['name'] }} </a>
</li>
@endforeach

@if(count($acategory_data) >4)
<li><a class="dropdown-item" href="{{ URL::to('/acategory') }}" title="View All">View All</a></li>
@endif
</ul>
</div>
</li>
@endif
@endisset

<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" title="Gallery">Gallery <img src="{{ asset('assets/frontend/images/arrow_dwn.svg') }}" width="20" height="20" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></a>
<div class="dropdown-menu">
<ul class="m-0 p-0">
<li><a class="dropdown-item" href="{{ URL::to('/image-album') }}" title="Image Gallery">Image Gallery</a></li>
<li><a class="dropdown-item" href="{{ URL::to('/video-album') }}" title="Video Gallery">Video Gallery</a></li>
</ul>
</div>
</li>
<li class="nav-item">
<a class="nav-link" href="{{ URL::to("blogCategory") }}" title="Blog">Blog</a></li>

<li class="nav-item"><a class="nav-link" href="{{ URL::to('/contact-us') }}" title="Contact Us">Contact Us</a></li>
</ul>
</div>
</div>
</div>
</nav>
<div class="header_rgt d-flex align-items-center">
<!--<div class="d-inline-block oth_logos"> <img src="{{ asset('assets/frontend/images/ce_logo.png') }}" width="45" height="45" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"> <img src="{{ asset('assets/frontend/images/g_logo.png') }}" width="45" height="45" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"> </div>-->
<div class="d-inline-block call_us_header fw-semibold me-2"> <a href="#"><img src="{{ asset('assets/frontend/images/call.svg') }}" width="15" height="15" title="" alt="" decoding="async" fetchpriority="low" loading="lazy">{{ $settings->contact->contact_no }}</a> </div>
<div class="srch_mob shownext d-inline-block text-center rounded-2"> <a href="javascript:void()" class="rounded-2 text-uppercase"><!--<span class="me-1"></span>--> <img src="{{ asset('assets/frontend/images/search_ico.svg') }}" width="20" height="20" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></a> </div>

<div class="srch_area float-start mt-4">
<form id="searchForm" method="GET" action="{{ route('products.index') }}" autocomplete="off">
@csrf
<div class="srch_inner position-relative d-flex pe-lg-5 rounded-2 w-100">
<div class="srch_sec1">
<input name="keyword" type="text" id="inputProductSearch" placeholder="Search entire products here..." value="<?php echo old('keyword');?>" onKeyUp="lookup(this.value);" onBlur="fill();" >
<div class="suggestionsBox" id="suggestions" style="display:none;">
    <div class="suggestionList" id="autoSuggestionsList"></div>
</div>
</div>

@php
    use App\Models\Category; 
    $oldcategory_id = old('category_id');
    $categories = Category::printCategory($oldcategory_id, $layer = 3);
@endphp

<div class="srch_sec2">
<select id="category_id" name="category_id">
    <option value="">Select Category</option>
    {!! $categories !!}
</select>
<?php
/*
<select name="category_id" id="category_id">
<option value="">Select Categories</option>
@foreach($category_data as $category)
<option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
@endforeach
</select>
*/
?>
</div>
<div class="srch_sec4 position-absolute end-0">
<button type="submit"> <img src="{{ asset('assets/frontend/images/search_ico.svg') }}" width="20" height="20" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></button>
</div>
<p class="clearfix"></p>
</div>

</div>
</form>
</div>
</div>
<!--Nav end-->
</div>
</div>
</div>
</div>
</header>
<!-- #EndLibraryItem -->
<!--Header end-->





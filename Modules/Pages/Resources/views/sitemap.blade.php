@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | {{ config('app.description') }}
@endsection
@section('main-content')
@include('frontend.layouts.partials.inner-banner')

<nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a>
<li class="breadcrumb-item active" aria-current="page">Sitemap</li>
</ol>
</div>
</nav>

<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Sitemap </h1>


<div class="mt-4 box_style">
<p class="fw-bold text-uppercase exo">QUICK LINKS</p>

<div class="sitemap_link mb-2 mt-2">
<a href="{{ URL::to('/')  }}" title="Home">Home</a>
<a href="{{ URL::to('/about-us')  }}" title="About Us">About Us</a>
<a href="{{ URL::to('/products')  }}" title="Products">Products</a>
<a href="{{ URL::to('/services')  }}" title="Services">Services</a>
<a href="{{ URL::to('/vision-mission')  }}" title="Vision &amp; Mission">Vision &amp; Mission</a>

<a href="{{ URL::to('/acategory')  }}" title="Applications">Applications</a>
<a href="{{ URL::to('/contact-us')  }}" title="Contact Us">Contact Us</a>
<a href="{{ URL::to('/blogCategory')  }}" title="Blog">Blog</a>

<a href="{{ URL::to('/instant-offer')  }}" title="Get Instant Offer">Get Instant Offer</a>
<a href="{{ URL::to('/faqs')  }}" title="FAQ's">FAQ's</a>
<a href="{{ URL::to('/testimonials')  }}" title="Testimonials">Testimonials</a>

<a href="{{ URL::to('/cookies-policy')  }}" title="Cookies Policy">Cookies Policy</a>  
<a href="{{ URL::to('/privacy-policy')  }}" title="Privacy Policy">Privacy Policy</a>  
<a href="{{ URL::to('/legal-disclaimer')  }}" title="Legal Disclaimer">Legal Disclaimer</a> 
<a href="{{ URL::to('/terms-conditions')  }}" title="Terms and Conditions">Terms and Conditions</a>  
</div>



</div>



</div>
</div>

<div class="clearfix"></div>

@endsection

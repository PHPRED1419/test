@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | {{ config('app.description') }}
@endsection
@section('main-content')
@include('frontend.layouts.partials.inner-banner')
<a name="contactForm"></a>
<nav aria-label="breadcrumb" class="breadcrumb_bg">
<div class="container-xxl position-relative">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('/')  }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">Contact Us </h1>

<div class="row">
<div class="col-12 col-lg-4">
<div class="contact_all_dtls mt-3">

<h4 class="fw-bold">Contact Information</h4>
<div class="contacts_list mt-3">
<ul class="m-0 p-0">
<li>
<b class="text-center rounded-circle d-inline-block text-white"><img src="{{ asset('images/call2.svg') }}" class="" width="20" height="20" alt="" loading="lazy" fetchpriority="low" decoding="async"></b>
<div class="cont_info_dtl">
<span class="d-block text-uppercase fw-medium">Phone</span>
<a href="tel:90547729000">{{ $settings->contact->contact_no }}</a>
</div>
</li>

<li>
<b class="text-center rounded-circle d-inline-block text-white"><img src="{{ asset('images/email.svg') }}" class="" width="20" alt="" loading="lazy" fetchpriority="low" decoding="async"></b>
<div class="cont_info_dtl">
<span class="d-block text-uppercase fw-medium">Email</span>
<a href="mailto:info@universalboschi.net">{{ $settings->contact->email_primary }}</a>
</div>
</li>
</ul>
</div>
  
<hr class="hr_1">

<h4 class="fw-bold">Address </h4>
<div class="contacts_list mt-3">
<ul class="m-0 p-0">
<li>
<b class="text-center rounded-circle d-inline-block text-white"><img src="{{ asset('images/location.svg') }}" class="" width="20" alt="" loading="lazy" fetchpriority="low" decoding="async"></b>
<div class="cont_info_dtl">
<span class="d-block text-uppercase fw-medium">Location</span>
{{ $settings->contact->address }}
</div>
</li>
</ul>
</div>
</div>

</div>

<div class="col-12 col-lg-7 offset-lg-1">

@if(session('success'))
    <div class="alert alert-success" style="font-size: 23px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="font-size: 23px;">
        {{ session('error') }}
    </div>
@endif
<div class="contact_form_info contact_form_bg">
<h3 class="fw-bold luckiest">Get in Touch with Us</h3> 

<form action="{{ route('contact_us.submit') }}#contactForm" method="POST" id="contactForm">
    @csrf
<div class="row">            
    <div class="col-xl-6 col-sm-6 col-12">
        <div class="form-field">
            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"  placeholder="First Name *">
            @error('first_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-sm-6 col-12">
        <div class="form-field">
            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"  id="last_name" placeholder="Last Name">
        </div>
    </div>
    <div class="col-xl-6 col-sm-6 col-12">
        <div class="form-field">
            <input type="tel" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}"  id="mobile_number" placeholder="Mobile No. *">
            @error('mobile_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6 col-sm-6 col-12">
        <div class="form-field">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Email *">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-field">
            <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Comment *">{{ old('message') }}</textarea>
            @error('message')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-info text-uppercase fw-bold rounded-5">Submit</button>
    </div>
</div>
</form>
</div>
</div></div>

</div>
</div>

<div class="contact_map mt-4 overflow-hidden">
{!! $settings->contact->google_map !!}
</div>
</div>

<div class="clearfix"></div>

@endsection
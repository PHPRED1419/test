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
<li class="breadcrumb-item active" aria-current="page">FAQ's</li>
</ol>
</div>
</nav>

<div class="mt-3 mb-5">
<div class="container-xxl position-relative">
<div class="cms_area">
<h1 class="fw-bold mb-2">FAQ's </h1>

<div class="faq_wraper p-3 shadow">
  <div class="accordion" id="index" itemscope="" itemtype="http://schema.org/">
  @forelse($faqs as $index => $row)
  <div class="accordion-item rounded-2 overflow-hidden" itemprop="mainEntity" itemscope="" itemtype="http://schema.org/Question">
  <p class="accordion-header" itemprop="name"><button class="fw-medium accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fq{{$index}}" aria-expanded="false" aria-controls="collapse{{$index}}">{{ $row['faq_question'] }}</button></p>
    
  <div id="fq{{$index}}" class="accordion-collapse collapse" data-bs-parent="#index" itemprop="acceptedAnswer" itemscope="" itemtype="http://schema.org/Answer" style="">
  <div class="accordion-body p-2 rounded-bottom rounded-bottom-3 fw-medium bg-white" itemprop="text">{!! $row['faq_answer'] !!}</div>
  </div>
  </div>
  @empty
        <div class="col-12 justify-content-center">
            <div class="alert alert-info text-center py-4">
                <h4>No faq's found</h4>
                <p>We couldn't find any faq's matching your criteria</p>
                    {{-- <a href="URL::to('/')" class="btn btn-primary">Return to Home</a> --}}
            </div>
        </div>
  @endforelse 
  </div>
  </div>

</div>
</div>
</div>

  </div>


<div class="clearfix"></div>

@endsection

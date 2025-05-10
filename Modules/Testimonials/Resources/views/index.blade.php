@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | Testimonials
@endsection

@section('main-content')
@include('frontend.layouts.partials.inner-banner')

<nav aria-label="breadcrumb" class="breadcrumb_bg">
    <div class="container-xxl position-relative">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
            <li class="breadcrumb-item">Testimonials</li>
        </ol>
    </div>
</nav>

<div class="mt-3 mb-5">
    <div class="container-xxl position-relative">
        <div class="cms_area">
            <h1 class="fw-bold mb-2">Testimonials</h1>

            <div class="row m-0">
                <!-- Testimonials Listing -->
                <div class="col-lg-8 no_pad order-2 order-lg-1">
                    @forelse($testimonials as $index => $row)
                        <div class="testi_box_inr position-relative w-100 border border-primary border-opacity-25 shadow p-3 rounded-2 mb-3">
                            <div class="float-start me-2 me-md-3 position-relative">
                                <p class="testi_pic overflow-hidden rounded-3">
                                    <img src="{{ asset('assets/frontend/images/user.svg') }}" width="52" height="52" loading="lazy" decoding="async" fetchpriority="low" alt="" class="img-fluid">
                                </p>
                            </div>
                            <div class="float-start">
                                <p class="fs-5 fw-bold name vollkorn">{{ $row['name'] }}</p>
                                <p class="testi_date mt-1 fw-medium">
                                    <img src="{{ asset('assets/frontend/images/date.svg') }}" loading="lazy" width="18" height="18" alt="Date" class="align-middle"> 
                                    {{ $row['created_at']->format('jS F Y') }}
                                </p>
                            </div>
                            <p class="clearfix"></p>
                            <div class="t_text_12">    
                                <div>{{ $row['description'] }}</div>
                            </div>
                            @if(strlen($row['description']) > 200)
                            <p class="vw_more fw-bold mt-2">
                                <a href="javascript:void(0)" class="text-primary">Read More...</a>
                            </p>
                            @endif
                            <p class="clearfix"></p>
                        </div>
                    @empty
                        <div class="col-12 justify-content-center">
                            <div class="alert alert-info text-center py-4">
                                <h4>No testimonials found</h4>
                                <p>Be the first to share your experience!</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Testimonial Submission Form -->
                <div class="col-lg-4 no_pad ps-lg-4 order-1 order-lg-2">
                    <div class="post_testi_box p-2 p-md-3 rounded-2 shadow mb-3">
                        <h2 class="text-uppercase fw-bold d-none d-lg-block text-white">Post Testimonials</h2>
                        <h2 class="text-uppercase fw-bold d-block d-lg-none shownext text-white">
                            <img src="{{ asset('assets/frontend/images/menu.svg') }}" loading="lazy" width="22" height="22" alt="" class="align-middle"> Post Testimonials
                        </h2>
                        
                        <div class="tab_hid">
                        @if(session('success'))
                            <div class="alert alert-success" style="font-size: 17px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" style="font-size: 17px;">
                                {{ session('error') }}
                            </div>
                        @endif

                            <form action="{{ route('testimonials.store') }}" method="POST" id="testimonialForm">
                                @csrf
                                
                                <div class="mt-2">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name *" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mt-2">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email ID *" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mt-2">
                                    <textarea rows="3" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Comment *" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <?php
                                /*
                                <!-- CAPTCHA Section -->
                                <div class="mt-2">
                                    <div class="clearfix align-middle">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Code *" required>
                                                @error('captcha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <span class="bg-light p-1 rounded me-2">{!! captcha_img() !!}</span>
                                                    <button type="button" class="btn btn-sm btn-outline-light" onclick="refreshCaptcha()">
                                                        <img src="{{ asset('assets/frontend/images/ref.svg') }}" alt="Refresh">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-1 d-block text-white">
                                        <small>Type the characters shown above.</small>
                                    </div>
                                </div>
                                */
                                ?>
                                <div class="mt-2 fw-bolder roboto">
                                    <button type="submit" class="btn btn-text text-uppercase w-100">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
@endsection

@push('scripts')
<script>
    function refreshCaptcha() {
        $.ajax({
            url: "{{ route('refresh.captcha') }}",
            type: 'GET',
            success: function(data) {
                $('.captcha span').html(data.captcha);
            }
        });
    }

    // Form validation
    document.getElementById('testimonialForm').addEventListener('submit', function(e) {
        const form = this;
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
</script>
@endpush
  <!-- Footer -->
  <?php
  //echo "<pre>";
 // print_r($settings);
//exit;
  ?>
<div class="clearfix"></div>
<!--Footer-->
<footer>
<div class="foot2 pt-3 pt-lg-5">
<div class="container-xxl">
<div class="row">
<div class="col-md-6 col-lg-4 ">
<h3 class="d-block d-md-none dd_next hand ft_heading fw-semibold d-block  text-uppercase exo text-uppercase">Contact Details</h3>

<div class="f_dd_box">
<div class="ft_cont_dtl p-3 p-md-4 position-relative">
<div class="ft_logo mb-4 mt-3">
<a href="{{ URL::to('/')  }}" title="UNIVERSAL BOSCHI"><img src="{{ asset('assets/frontend/images/ft_logo.jpg') }}" width="317" height="51" title="UNIVERSAL BOSCHI" alt="" decoding="async" fetchpriority="low" loading="lazy" class="img-fluid"></a>
</div>

<p class="foot_contact fw-light pt-2 mb-4">
<span class="text-white d-block fw-medium">
<b class="fw-bold d-block mb-3">{{ $settings->general->copyright_text }}</b>
</span> 
</p>

<p class="foot_contact fw-light mt-3">
<i class="text-center float-start me-2"><img src="{{ asset('assets/frontend/images/email.svg') }}" width="18" height="18" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></i>

<span class="text-white d-block">
<a href="mailto:info@universalboschi.net" title="">{{ $settings->contact->email_primary }}</a></span> </p>

<p class="foot_contact fw-light mt-2">
<i class="text-center float-start me-2"><img src="{{ asset('assets/frontend/images/call2.svg') }}" width="18" height="18" title="" alt="" decoding="async" fetchpriority="low" loading="lazy"></i>
<span class="text-white d-block">
<a class="d-block" href="tel:+919871872626">{{ $settings->contact->contact_no }}</a></span></p>

</div>
</div>


</div>

<div class="col-md-6 col-lg-4 ps-lg-4">
<h3 class="d-none d-md-block ft_heading fw-semibold d-block vollkorn">Quick Links</h3>
<h3 class="d-block d-md-none dd_next hand ft_heading fw-semibold vollkorn">Quick Links</h3>

<div class="f_dd_box">
<div class="ft_bx">
<div class="ft_link  fw-medium">
<ul>
<li><a href="{{ URL::to('/')  }}" title="Home">Home</a></li>
<li><a href="{{ URL::to('/about-us')  }}" title="About Us">About Us</a></li>
<li><a href="{{ URL::to('/products')  }}" title="Products">Products</a></li>
<li><a href="{{ URL::to('/services')  }}" title="Services">Services</a></li>
<li><a href="{{ URL::to('/vision-mission')  }}" title="Vision &amp; Mission">Vision &amp; Mission</a></li>

<li><a href="{{ URL::to('/acategory')  }}" title="Applications">Applications</a></li>
<li><a href="{{ URL::to('/contact-us')  }}" title="Contact Us">Contact Us</a></li>
<li><a href="{{ URL::to('/blogCategory')  }}" title="Blog">Blog</a></li>

</ul>
</div></div>

<div class="ft_bx">
<div class="ft_link fw-medium">
<ul>
<li><a href="{{ URL::to('/instant-offer')  }}" title="Get Instant Offer">Get Instant Offer</a></li>
<li><a href="{{ URL::to('/faqs')  }}" title="FAQ's">FAQ's</a></li>
<li><a href="{{ URL::to('/testimonials')  }}" title="Testimonials">Testimonials</a></li>
<li><a href="{{ URL::to('/sitemap')  }}" title="Sitemap">Sitemap</a></li>
</ul>
</div>
</div></div>
</div>


<div class="col-md-8 col-lg-4">
<h3 class="d-none d-md-block ft_heading fw-semibold vollkorn">Newsletter Subscribe</h3>
<h3 class="d-block d-md-none dd_next hand ft_heading fw-semibold vollkorn">Newsletter Subscribe</h3>

<div class="f_dd_box">
        <div class="nws_ltr">
            <div id="newsletter-message" class="mb-2" style="display: none;"></div>
            
            <p class="nws_txt fw-normal">Enter Your Email Address To Sign Up For Our
            Special Offers And Product Promotions</p>
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
            
            <form id="newsletterForm" method="POST" action="{{ route('newsletter.subscribe') }}">
                @csrf
                <div class="g-2 mt-2">
                    <div class="newsl_field mb-2 border border-muted">
                        <input name="email" type="email" id="newsletter-email" 
                               class="form-control" 
                               placeholder="Enter Your Email Address *" required>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>

                    <?php /* <div class="news2_field mb-2 border border-muted pe-2">
                        <div class="row g-0">
                            <div class="col-6">
                                <input name="captcha" type="text" id="newsletter-captcha"
                                       class="form-control" 
                                       placeholder="Enter Code *" required>
                                <div class="invalid-feedback" id="captcha-error"></div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-end h-100">
                                    <span class="me-2" id="captcha-image">{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-sm refresh-captcha">
                                        <img src="{{ asset('assets/frontend/images/ref.svg') }}" alt="Refresh" loading="lazy">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> */ ?>
                    
                    <div class="news3_field">
                        <button type="submit" class="subsc_btn text-uppercase fw-medium" id="newsletter-submit">
                            <span id="submit-text">Subscribe</span>
                            <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script>
  $(document).ready(function() {
    // Refresh CAPTCHA
    $('.refresh-captcha').click(function(){
        $.ajax({
            url: "{{ route('refresh.captcha') }}",
            type: 'GET',
            success: function(data) {
                $('#captcha-image').html(data.captcha);
            }
        });
    });

    // Newsletter Form Submission
    $('#newsletterForm').submit(function(e) {
        e.preventDefault();
        
        // Reset errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#newsletter-message').hide();
        
        // Show loading state
        $('#newsletter-submit').prop('disabled', true);
        $('#submit-text').addClass('d-none');
        $('#spinner').removeClass('d-none');
        
        $.ajax({
            url: "{{ route('newsletter.subscribe') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
              alert("Thank you for subscribing to our newsletter!");
              return false;
                // Show success message
                $('#newsletter-message').removeClass('alert-danger').addClass('alert-success')
                    .html(response.message).show();
                
                // Reset form
                $('#newsletterForm')[0].reset();
                refreshCaptcha();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        $(`#newsletter-${field}`).addClass('is-invalid');
                        $(`#${field}-error`).text(errors[field][0]);
                    }
                    
                    $('#newsletter-message').removeClass('alert-success').addClass('alert-danger')
                        .html('Please fix the errors in the form.').show();
                } else {
                    // Other errors
                    $('#newsletter-message').removeClass('alert-success').addClass('alert-danger')
                        .html(xhr.responseJSON.message || 'An error occurred. Please try again.').show();
                }
            },
            complete: function() {
                // Reset button state
                $('#newsletter-submit').prop('disabled', false);
                $('#submit-text').removeClass('d-none');
                $('#spinner').addClass('d-none');
            }
        });
    });

    // Function to refresh CAPTCHA
    function refreshCaptcha() {
        $.ajax({
            url: "{{ route('refresh.captcha') }}",
            type: 'GET',
            success: function(data) {
                $('#captcha-image').html(data.captcha);
            }
        });
    }
});
</script>
<div class="follow_link d-flex justify-content-lg-end mt-4">
<a href="{{ $settings->social->facebook }}" width="19" height="19" title="Facebook" alt="" decoding="async" fetchpriority="low" loading="lazy"><i class="text-center d-block"><img src="{{ asset('assets/frontend/images/icon_fb.svg') }}" width="19" height="19" title="Facebook" alt="" decoding="async" fetchpriority="low" loading="lazy"></i> </a>
<a href="{{ $settings->social->twitter }}" title="Twitter"><i class="text-center d-block"><img src="{{ asset('assets/frontend/images/icon_tw.svg') }}" width="19" height="19" title="Twitter" alt="" decoding="async" fetchpriority="low" loading="lazy"></i></a>
<a href="{{ $settings->social->instagram }}" title="Instagram"><i class="text-center d-block"><img src="{{ asset('assets/frontend/images/icon_insta.svg') }}" width="19" height="19" title="Instagram" alt="" decoding="async" fetchpriority="low" loading="lazy"></i> </a>
<a href="{{ $settings->social->linkedin }}" title="Linkedin In"><i class="text-center d-block"><img src="{{ asset('assets/frontend/images/icon_in.svg') }}" width="19" height="19" title="Linkedin In" alt="" decoding="async" fetchpriority="low" loading="lazy"></i> </a>
<a href="{{ $settings->social->youtube }}" title="Youtube"><i class="text-center d-block"><img src="{{ asset('assets/frontend/images/icon_yt.svg') }}" width="19" height="19" title="Youtube" alt="" decoding="async" fetchpriority="low" loading="lazy"></i> </a>
<a href="{{ $settings->social->pinterest }}" title="Pinterest"><i class="text-center d-block"><img src="{{ asset('assets/frontend/images/icon_pinterest.svg') }}" width="19" height="19" title="Pinterest" alt="" decoding="async" fetchpriority="low" loading="lazy"></i> </a>
</div>

</div></div>

</div>

<div class="ft_middle pt-4 pb-4 mt-4">
<div class="container-xxl">
<div class="row">
<div class="col-12  col-lg-5">
<div class="copy_rgt d-block fw-medium mt-2">{{ $settings->general->copyright_text }}</div>

</div>
<div class="col-12 col-lg-7">
<div class="quick_links text-center text-lg-end">
<a href="{{ URL::to('/cookies-policy')  }}" title="Cookies Policy">Cookies Policy</a>  
<a href="{{ URL::to('/privacy-policy')  }}" title="Privacy Policy">Privacy Policy</a>  
<a href="{{ URL::to('/legal-disclaimer')  }}" title="Legal Disclaimer">Legal Disclaimer</a> 
<a href="{{ URL::to('/terms-conditions')  }}" title="Terms and Conditions">Terms and Conditions</a>   </div></div>
</div>


</div>

</div>

</div>

</footer>
<!-- #EndLibraryItem -->
<div class="float_icons">
<div class="float_whatsapp position-relative">
<a href="https://api.whatsapp.com/send?phone={{ $settings->contact->contact_no }}&text={{ $settings->contact->whatsapp_text }}" class="text-white" target="_blank"><span class="float_whatsapp_txt">Whatsapp</span><img src="{{ asset('assets/frontend/images/whatsapp-icon.svg') }}" alt="Whatsapp" loading="lazy" fetchpriority="low" decoding="async"></a>
</div>
<div class="float_contact position-relative">
<a href="mailto:{{ $settings->contact->email_primary }}" class="text-white"><span class="float_contact_txt text-nowrap">Inquiry Us</span><img src="{{ asset('assets/frontend/images/email2.svg') }}" alt="Inquiry" loading="lazy" fetchpriority="low" decoding="async"></a>
</div>
<div class="float_call position-relative">
<a href="tel:{{ $settings->contact->phone }}" class="text-dark"><span class="float_call_txt text-nowrap">Call Us</span><img src="{{ asset('assets/frontend/images/call3.svg') }}" alt="Call Us" loading="lazy" fetchpriority="low" decoding="async"></a>
</div>
</div>

<p id="back-top"><a href="#top"><span></span></a></p>
<!--Footer End-->

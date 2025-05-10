<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.instant_offer_enquiry.index'))
                Instant Offer Enquiry List
                @elseif (Route::is('admin.instant_offer_enquiry.show'))
                    View Message
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.instant_offer_enquiry.index'))
                            <li class="breadcrumb-item active" aria-current="page">Instant Offer Enquiry List</li>
                        @elseif (Route::is('admin.instant_offer_enquiry.show'))
                            <li class="breadcrumb-item active" aria-current="page">View Instant Offer Enquiry</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

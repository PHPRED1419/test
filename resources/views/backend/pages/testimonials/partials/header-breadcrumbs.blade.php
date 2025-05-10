<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.testimonials.index'))
                Testimonial List
                @elseif(Route::is('admin.testimonials.create'))
                    Post Testimonial    
                @elseif(Route::is('admin.testimonials.edit'))
                    Edit Testimonial 
                @elseif(Route::is('admin.testimonials.show'))
                    View Testimonial </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.testimonials.edit', $testimonial->testimonial_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.testimonials.index'))
                            <li class="breadcrumb-item active" aria-current="page">Testimonial List</li>
                        @elseif(Route::is('admin.testimonials.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonial List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Post Testimonial</li>
                        @elseif(Route::is('admin.testimonials.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonial List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Testimonial</li>
                        @elseif(Route::is('admin.testimonials.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonial List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Testimonial</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.faqs.index'))
                Faq's List
                @elseif(Route::is('admin.faqs.create'))
                    Create New Faq    
                @elseif(Route::is('admin.faqs.edit'))
                    Edit Faq 
                @elseif(Route::is('admin.faqs.show'))
                    View Faq </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.faqs.edit', $faq->faq_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.faqs.index'))
                            <li class="breadcrumb-item active" aria-current="page">Faq's List</li>
                        @elseif(Route::is('admin.faqs.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">Faq's List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Faq</li>
                        @elseif(Route::is('admin.faqs.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">Faq's List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Faq</li>
                        @elseif(Route::is('admin.faqs.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">Faq's List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Faq's</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
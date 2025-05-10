<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.banners.index'))
                Banner List
                @elseif(Route::is('admin.banners.create'))
                    Create New Banner    
                @elseif(Route::is('admin.banners.edit'))
                    Edit Banner 
                @elseif(Route::is('admin.banners.show'))
                    View Banner </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.banners.edit', $banner->banner_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.banners.index'))
                            <li class="breadcrumb-item active" aria-current="page">Banner List</li>
                        @elseif(Route::is('admin.banners.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Banner</li>
                        @elseif(Route::is('admin.banners.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
                        @elseif(Route::is('admin.banners.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Banner</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
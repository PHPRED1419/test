<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.flashes.index'))
                Flash Banner List
                @elseif(Route::is('admin.flashes.create'))
                    Create New Flash Banner    
                @elseif(Route::is('admin.flashes.edit'))
                    Edit Flash Banner 
                @elseif(Route::is('admin.flashes.show'))
                    View Flash Banner </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.flashes.edit', $flashe->flash_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.flashes.index'))
                            <li class="breadcrumb-item active" aria-current="page">Banner List</li>
                        @elseif(Route::is('admin.flashes.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.flashes.index') }}">Banner List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Banner</li>
                        @elseif(Route::is('admin.flashes.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.flashes.index') }}">Banner List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
                        @elseif(Route::is('admin.flashes.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.flashes.index') }}">Banner List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Banner</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
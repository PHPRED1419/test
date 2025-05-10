<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.colors.index'))
                Color List
                @elseif(Route::is('admin.colors.create'))
                    Create New Color    
                @elseif(Route::is('admin.colors.edit'))
                    Edit Color 
                @elseif(Route::is('admin.colors.show'))
                    View Color </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.colors.edit', $colors->id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.colors.index'))
                            <li class="breadcrumb-item active" aria-current="page">Size List</li>
                        @elseif(Route::is('admin.colors.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.colors.index') }}">Size List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Size</li>
                        @elseif(Route::is('admin.colors.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.colors.index') }}">Size List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Size</li>
                        @elseif(Route::is('admin.colors.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.colors.index') }}">Size List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Size</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
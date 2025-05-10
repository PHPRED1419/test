<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.parts.index'))
                Model List
                @elseif(Route::is('admin.parts.create'))
                    Create New Model    
                @elseif(Route::is('admin.parts.edit'))
                    Edit Model 
                @elseif(Route::is('admin.parts.show'))
                    View Model </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.parts.edit', $part->id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.parts.index'))
                            <li class="breadcrumb-item active" aria-current="page">Model List</li>
                        @elseif(Route::is('admin.parts.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.parts.index') }}">Model List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Model</li>
                        @elseif(Route::is('admin.parts.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.parts.index') }}">Model List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Model</li>
                        @elseif(Route::is('admin.parts.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.parts.index') }}">Model List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Model</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
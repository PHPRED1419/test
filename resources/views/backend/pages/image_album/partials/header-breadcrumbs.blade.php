<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.image_album.index'))
                Image Album List
                @elseif(Route::is('admin.image_album.create'))
                    Create New Image Album    
                @elseif(Route::is('admin.image_album.edit'))
                    Edit Image Album 
                @elseif(Route::is('admin.image_album.show'))
                    View Image Album </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.image_album.edit', $category->category_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.image_album.index'))
                            <li class="breadcrumb-item active" aria-current="page">Image Album List</li>
                        @elseif(Route::is('admin.image_album.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.image_album.index') }}">Image Album List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Album</li>
                        @elseif(Route::is('admin.image_album.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.image_album.index') }}">Image Album List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Album</li>
                        @elseif(Route::is('admin.image_album.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.image_album.index') }}">Image Album List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Image Album</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
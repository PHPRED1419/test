<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.video_gallery.index'))
                Video Gallery List
                @elseif(Route::is('admin.video_gallery.create'))
                    Create New Video Gallery    
                @elseif(Route::is('admin.video_gallery.edit'))
                    Edit Video Gallery 
                @elseif(Route::is('admin.video_gallery.show'))
                    View Video Gallery </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.video_gallery.edit', $gallery->gallery_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.video_gallery.index'))
                            <li class="breadcrumb-item active" aria-current="page">Video Gallery List</li>
                        @elseif(Route::is('admin.video_gallery.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.video_gallery.index') }}">Video Gallery List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Video Gallery</li>
                        @elseif(Route::is('admin.video_gallery.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.video_gallery.index') }}">Video Gallery List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Video Gallery</li>
                        @elseif(Route::is('admin.video_gallery.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.video_gallery.index') }}">Video Gallery List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Video Gallery</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
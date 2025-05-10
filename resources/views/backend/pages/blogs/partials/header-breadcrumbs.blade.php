<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.blogs.index'))
                    Blog List
                @elseif(Route::is('admin.blogs.create'))
                    Create New Blog    
                @elseif(Route::is('admin.blogs.edit'))
                    Edit Blog 
                @elseif(Route::is('admin.blogs.show'))
                    View Blog </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.blogs.edit', $blog->id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.blogs.index'))
                            <li class="breadcrumb-item active" aria-current="page">Blog List</li>
                        @elseif(Route::is('admin.blogs.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Blog</li>
                        @elseif(Route::is('admin.blogs.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
                        @elseif(Route::is('admin.blogs.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Blog</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
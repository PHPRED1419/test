<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.blogsCategories.index'))
                Blogs categories List
                @elseif(Route::is('admin.blogsCategories.create'))
                    Create New Category    
                @elseif(Route::is('admin.blogsCategories.edit'))
                    Edit Category 
                @elseif(Route::is('admin.blogsCategories.show'))
                    View Category </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.blogsCategories.edit', $category->category_id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.blogsCategories.index'))
                            <li class="breadcrumb-item active" aria-current="page">Blog Category List</li>
                        @elseif(Route::is('admin.blogsCategories.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.blogsCategories.index') }}">Blog Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Blog Category</li>
                        @elseif(Route::is('admin.blogsCategories.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.blogsCategories.index') }}">Blog Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Blog Category</li>
                        @elseif(Route::is('admin.blogsCategories.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.blogsCategories.index') }}">Blog Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show Blog Category</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
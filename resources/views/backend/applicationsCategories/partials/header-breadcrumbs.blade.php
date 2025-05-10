<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.applicationsCategories.index'))
                Application Category List
                @elseif(Route::is('admin.applicationsCategories.create'))
                    Create New Application Category    
                @elseif(Route::is('admin.applicationsCategories.edit'))
                    Edit Application Category <span class="badge badge-info">{{ $applicationsCategories->name }}</span>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.applicationsCategories.index'))
                            <li class="breadcrumb-item active" aria-current="page">Application Category List</li>
                        @elseif(Route::is('admin.applicationsCategories.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.applicationsCategories.index') }}">Application Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Application Category</li>
                        @elseif(Route::is('admin.applicationsCategories.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.applicationsCategories.index') }}">Application Category List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Application Category</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
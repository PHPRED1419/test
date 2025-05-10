<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.keywords.index'))
                keywords List
                @elseif(Route::is('admin.keywords.create'))
                    Create New keywords    
                @elseif(Route::is('admin.keywords.edit'))
                    Edit keywords 
                @elseif(Route::is('admin.keywords.show'))
                    View keywords </span>
                    <a  class="btn btn-outline-success btn-sm" href="{{ route('admin.keywords.edit', $keywords->id) }}"> <i class="fa fa-edit"></i></a>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.keywords.index'))
                            <li class="breadcrumb-item active" aria-current="page">keywords List</li>
                        @elseif(Route::is('admin.keywords.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.keywords.index') }}">keywords List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New keywords</li>
                        @elseif(Route::is('admin.keywords.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.keywords.index') }}">keywords List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit keywords</li>
                        @elseif(Route::is('admin.keywords.show'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.keywords.index') }}">keywords List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">keywords</li>
                        @endif
                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
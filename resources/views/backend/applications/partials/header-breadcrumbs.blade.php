<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-5 align-self-center">
            <h4 class="page-title">
                @if (Route::is('admin.applications.index'))
                Application List
                @elseif(Route::is('admin.applications.create'))
                    Create New Application    
                @elseif(Route::is('admin.applications.edit'))
                    Edit Application 
                    <br /> <span class="badge badge-info">{{ $application->application_name }}</span>
                @endif
            </h4>
        </div>
        <div class="col-12 col-md-7 d-none d-md-block align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        @if (Route::is('admin.applications.index'))
                            <li class="breadcrumb-item active" aria-current="page">Application List</li>
                        @elseif(Route::is('admin.applications.create'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.applications.index') }}">Application List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Application</li>
                        @elseif(Route::is('admin.applications.edit'))
                        <li class="breadcrumb-item"><a href="{{ route('admin.applications.index') }}">Applications List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Application</li>
                        @endif                        
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
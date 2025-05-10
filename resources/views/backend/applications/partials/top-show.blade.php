
<!-- ============================================================== -->
<!-- Top Show Data of Categorie List Page -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.applications.index') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">{{ $count_applications }}</h1>
                <h6 class="text-white">Total Applications</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.applications.index') }}'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">{{ $count_active_applications }}</h1>
                <h6 class="text-white">Active Applications</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.applications.trashed') }}'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white">{{ $count_applications - $count_active_applications }} / {{ $count_trashed_applications }} </h1>
                <h6 class="text-white">Inactive/Trashed Applications</h6>
            </div>
        </div>
    </div>

    @if (Auth::user()->can('application.create'))
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.applications.create') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Application</h6>
            </div>
        </div>
    </div>
    @endif
</div>

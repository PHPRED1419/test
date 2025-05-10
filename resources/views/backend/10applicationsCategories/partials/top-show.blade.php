
<!-- ============================================================== -->
<!-- Top Show Data of Categorie List Page -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.applicationsCategories.index') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">{{ $count_applicationsCategories }}</h1>
                <h6 class="text-white">Total Categories</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.applicationsCategories.index') }}'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">{{ $count_active_applicationsCategories }}</h1>
                <h6 class="text-white">Active Categories</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.applicationsCategories.trashed') }}'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white">{{ $count_applicationsCategories - $count_active_applicationsCategories }} / {{ $count_trashed_applicationsCategories }} </h1>
                <h6 class="text-white">Inactive/Trashed Categories</h6>
            </div>
        </div>
    </div>

    @if (Auth::user()->can('category.create'))
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.applicationsCategories.create') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Category</h6>
            </div>
        </div>
    </div>
    @endif
</div>

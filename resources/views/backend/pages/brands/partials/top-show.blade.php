
<!-- ============================================================== -->
<!-- Top Show Data of List Blog -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.brands.index') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">{{ $count_brands }}</h1>
                <h6 class="text-white">Total Blogs</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.brands.index') }}'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">{{ $count_active_brands }}</h1>
                <h6 class="text-white">Active Blogs</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.brands.trashed') }}'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white">{{ $count_brands - $count_active_brands }} / {{ $count_trashed_brands }} </h1>
                <h6 class="text-white">Inactive/Trashed Blogs</h6>
            </div>
        </div>
    </div>

    @if (Auth::user()->can('blog.create'))
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.brands.create') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Blog</h6>
            </div>
        </div>
    </div>
    @endif

</div>

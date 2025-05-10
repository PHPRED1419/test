
<!-- ============================================================== -->
<!-- Top Show Data of List Blog -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.image_gallery.index') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">{{ $count_photo }}</h1>
                <h6 class="text-white">Total Gallery</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.image_gallery.index') }}'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">{{ $count_active_photo }}</h1>
                <h6 class="text-white">Active Gallery</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.image_gallery.trashed') }}'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white">{{ $count_photo - $count_active_photo }} / {{ $count_trashed_photo }} </h1>
                <h6 class="text-white">Inactive/Trashed Gallery</h6>
            </div>
        </div>
    </div>

    @if (Auth::user()->can('ImageGallery.create'))
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.image_gallery.create') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Gallery </h6>
            </div>
        </div>
    </div>
    @endif

</div>

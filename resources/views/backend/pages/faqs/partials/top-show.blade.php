
<!-- ============================================================== -->
<!-- Top Show Data of List Blog -->
<!-- ============================================================== -->
<div class="row mt-1">
    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.faqs.index') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">{{ $count_faqs }}</h1>
                <h6 class="text-white">Total Faq's</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer"  onclick="location.href='{{ route('admin.faqs.index') }}'">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">{{ $count_active_faqs }}</h1>
                <h6 class="text-white">Active Faq's</h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.faqs.trashed') }}'">
        <div class="card card-hover">
            <div class="box bg-primary text-center">
                <h1 class="font-light text-white">{{ $count_faqs - $count_active_faqs }} / {{ $count_trashed_faqs }} </h1>
                <h6 class="text-white">Inactive/Trashed Faq's</h6>
            </div>
        </div>
    </div>

    @if (Auth::user()->can('faqs.create'))
    <div class="col-md-6 col-lg-3 col-xlg-3 pointer" onclick="location.href='{{ route('admin.faqs.create') }}'">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fa fa-plus-circle"></i>
                </h1>
                <h6 class="text-white">Create New Faq</h6>
            </div>
        </div>
    </div>
    @endif

</div>

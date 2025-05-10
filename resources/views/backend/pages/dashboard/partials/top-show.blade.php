@php $user = Auth::user(); @endphp

<!-- ============================================================== -->
<!-- Dashboard Page Top Data -->
<!-- ============================================================== -->
<div class="card-group">

    
    <div class="container">
    <div class="row">
    @if ($user->can('admin.view'))
        <?php /*?><div class="col-md-3 col-xl-2">
            <div class="card bg-c-blue order-card card-hover">
                <div class="card-block" onclick="location.href='{{ route('admin.admins.index') }}'">
                    <h6 class="m-b-20"></h6>
                    <h2 class="text-right"><i class="fa fa-user-circle f-left"></i><span></span></h2>
                    <p class="m-b-0" style="margin-left: 28px;"> Total Members <span class="f-right">{{ $count_admins }}</span></p>
                </div>
            </div>
        </div><?php */?>
        @endif

        @if ($user->can('category.view'))
        <div class="col-md-3 col-xl-2">
            <div class="card bg-c-green order-card card-hover">
                <div class="card-block" onclick="location.href='{{ route('admin.categories.index') }}'">
                    <h6 class="m-b-20"></h6>
                    <h2 class="text-right"><i class="fa fa-list-alt f-left"></i><span></span></h2>
                    <p class="m-b-0" style="margin-left: 28px;"> Total Category <span class="f-right">{{ $count_categories }}</span></p>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-3 col-xl-2">
            <div class="card bg-c-yellow order-card card-hover">
                <div class="card-block" onclick="location.href=''">
                    <h6 class="m-b-20"></h6>
                    <h2 class="text-right"><i class="fa fa-shopping-bag f-left"></i><span></span></h2>
                    <p class="m-b-0" style="margin-left: 26px;">Total Products<span class="f-right">{{ $count_products }}</span></p>
                </div>
            </div>
        </div>
        
        <?php /*?><div class="col-md-3 col-xl-2">
            <div class="card bg-c-pink order-card card-hover">
                <div class="card-block" onclick="location.href=''">
                    <h6 class="m-b-20"></h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span></span></h2>
                    <p class="m-b-0" style="margin-left: 32px;"> Total Orders <span class="f-right">0</span></p>
                </div>
            </div>
        </div><?php */?>

	</div>
</div>     
<!-- Column -->
</div>

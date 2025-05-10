
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <a href="<?php echo e(route('admin.index')); ?>" class="logo">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <?php if(empty($settings->general->logo)): ?>
                            <i class="wi wi-sunset"></i>
                        <?php endif; ?>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo- text-white">
                        <?php if(!empty($settings->general->logo)): ?>
                            <img src="<?php echo e(asset('assets/images/logo/' . $settings->general->logo)); ?>"
                                alt="<?php echo e(env('APP_NAME')); ?>" style="width: 200px;" title="<?php echo e(env('APP_NAME')); ?>"/>
                        <?php endif; ?>
                        <!-- dark Logo text -->
                        <?php
                        /*
                        <span>
                            {{ $settings->general->name }}
                        </span>
                        */
                        ?>
                    </span>
                </a>
                <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                    <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                        data-sidebartype="mini-sidebar">
                        <i class="mdi mdi-menu font-24"></i>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="<?php echo e(route('index')); ?>"
                        target="_blank">
                        <i class="mdi mdi-eye font-16"></i>
                        <span> View Site </span>
                    </a>
                </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">

                

                


                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href=""
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo e(asset(App\Helpers\ReturnPathHelper::getAdminImage(Auth::id()))); ?>" alt="user"
                            class="rounded-circle" width="40">
                        <span class="m-l-5 font-medium ">
                            <?php echo e(Auth::user()->first_name); ?>

                            <i class="mdi mdi-chevron-down"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <span class="with-arrow">
                            <span class="bg-primary"></span>
                        </span>
                        <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                            <div class="">
                                <img src="<?php echo e(asset(App\Helpers\ReturnPathHelper::getAdminImage(Auth::id()))); ?>"
                                    alt="user" class="rounded-circle" width="60">
                            </div>
                            <div class="m-l-10">
                                <h4 class="m-b-0"><?php echo e(Auth::user()->first_name); ?> </h4>
                                <p class=" m-b-0"><?php echo e(Auth::user()->email); ?> </p>
                            </div>
                        </div>

                        <div class="profile-dis scrollable" style="text-align: center;margin-top: 3px;">
                            <a href="<?php echo e(url('admin/settings/clear-cache')); ?>" class="btn btn-danger">Clear Cache</a>
                        </div>

                        <div class="profile-dis scrollable">
                            <a class="dropdown-item" href="<?php echo e(route('admin.admins.profile.edit')); ?>">
                                <i class="ti-user m-r-5 m-l-5"></i> Edit My Profile</a>
                            <a class="dropdown-item" href="javascript:void(0)"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                            
                        </div>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header><?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/layouts/partials/header.blade.php ENDPATH**/ ?>
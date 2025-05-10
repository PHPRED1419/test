<?php $user = Auth::user(); ?>

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <?php if($user->can('dashboard.view')): ?>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo e(route('admin.index')); ?>" aria-expanded="false">
                        <i class="mdi mdi-creation"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <?php endif; ?>
<?php /*
                @if ($user->can('admin.view') || $user->can('admin.create') || $user->can('role.view') || $user->can('role.create'))
                <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-account-switch"></i>
                        <span class="hide-menu"> Users Management </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level {{ (Route::is('admin.admins.index') || Route::is('admin.admins.create') || Route::is('admin.admins.edit')) ? 'in' : null }}">
                        @if ($user->can('admin.view'))
                        <li class="sidebar-item">
                            <a href="{{ route('admin.admins.index') }}" class="sidebar-link {{ (Route::is('admin.admins.index') || Route::is('admin.admins.edit')) ? 'active' : null }}">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Manage Users </span>
                            </a>
                        </li>
                        @endcan                        
                    </ul>
                </li>
                @endcan
<?php
*/
?>
                <?php if($user->can('category.view') || $user->can('category.create')): ?>
                <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-view-grid"></i>
                        <span class="hide-menu">Categories </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.categories.index') || Route::is('admin.categories.create') || Route::is('admin.categories.edit')) ? 'in' : null); ?>">
                        <?php if($user->can('category.view')): ?>
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.categories.index') || Route::is('admin.categories.edit')) ? 'active' : null); ?>">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Category List </span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if($user->can('category.create')): ?>
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.categories.create')); ?>" class="sidebar-link <?php echo e(Route::is('admin.categories.create') ? 'active' : null); ?>">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu"> New Category </span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if($user->can('keywords.view') || $user->can('keywords.create')): ?>

               <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-view-grid"></i>
                        <span class="hide-menu">keywords </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.keywords.index') || Route::is('admin.keywords.create') || Route::is('admin.keywords.edit')) ? 'in' : null); ?>">
                        <?php if($user->can('keywords.view')): ?>
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.keywords.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.keywords.index') || Route::is('admin.keywords.edit')) ? 'active' : null); ?>">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> keywords List </span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if($user->can('keywords.create')): ?>
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.keywords.create')); ?>" class="sidebar-link <?php echo e(Route::is('admin.keywords.create') ? 'active' : null); ?>">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu"> New keywords </span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>



                <?php
                /*               @if ($user->can('product.view') || $user->can('product.create'))
                <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-tune"></i>
                        <span class="hide-menu">Products </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level {{ (Route::is('admin.products.index') || Route::is('admin.products.create') || Route::is('admin.products.edit')) ? 'in' : null }}">
                       @if ($user->can('product.view'))
                        <li class="sidebar-item">
                            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ (Route::is('admin.products.index') || Route::is('admin.products.edit')) ? 'active' : null }}">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Products List </span>
                            </a>
                        </li>                       
                        @endif

                        @if ($user->can('product.create'))                        
                        <li class="sidebar-item">
                            <a href="{{ route('admin.products.create') }}" class="sidebar-link {{ Route::is('admin.products.create') ? 'active' : null }}">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu"> New Product </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

               
                <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-content-duplicate"></i>
                        <span class="hide-menu">Manage Entities </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level 
                    {{ (
                        Route::is('admin.sizes.index') || 
                        Route::is('admin.sizes.create') || 
                        Route::is('admin.sizes.edit') ||
                        Route::is('admin.parts.edit')

                        
                    ) ? 'in' : null }}">

                     @if ($user->can('brand.view'))
                        <li class="sidebar-item">
                            <a href="{{ route('admin.brands.index') }}" class="sidebar-link {{ (Route::is('admin.brands.index') || Route::is('admin.brands.edit')) ? 'active' : null }}">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Brand List </span>
                            </a>
                        </li>                       
                    @endif

                    @if ($user->can('part.view'))
                        <li class="sidebar-item">
                            <a href="{{ route('admin.parts.index') }}" class="sidebar-link {{ (Route::is('admin.parts.index') || Route::is('admin.parts.edit')) ? 'active' : null }}">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Model List </span>
                            </a>
                        </li>                       
                    @endif
                   
                    @if ($user->can('size.view'))
                        <li class="sidebar-item">
                            <a href="{{ route('admin.sizes.index') }}" class="sidebar-link {{ (Route::is('admin.sizes.index') || Route::is('admin.sizes.edit')) ? 'active' : null }}">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Size List </span>
                            </a>
                        </li>                       
                    @endif

                    @if ($user->can('color.view'))
                        <li class="sidebar-item">
                            <a href="{{ route('admin.colors.index') }}" class="sidebar-link {{ (Route::is('admin.colors.index') || Route::is('admin.colors.edit')) ? 'active' : null }}">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Color List </span>
                            </a>
                        </li>                       
                    @endif

                        
                    </ul>
                </li>
                */
                ?>



                

                <?php if($user->can('blog.view') || $user->can('blog.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Blogs </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.blogs.index') || Route::is('admin.blogs.create') || Route::is('admin.blogs.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('blog.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.blogsCategories.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.blogsCategories.index') || Route::is('admin.blogsCategories.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Blog Category </span>
                                    </a>
                                </li>
                                
                                 <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.blogs.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.blogs.index') || Route::is('admin.blogs.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Blog List </span>
                                    </a>
                                </li>
                                
                            <?php endif; ?>                            
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($user->can('imageAlbum.view') || $user->can('imageAlbum.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Image Gallery </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.image_album.index') || Route::is('admin.image_album.create') || Route::is('admin.image_album.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('imageAlbum.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.image_album.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.image_album.index') || Route::is('admin.image_album.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Image Album </span>
                                    </a>
                                </li>
                                
                                 <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.image_gallery.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.image_gallery.index') || Route::is('admin.image_gallery.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Image List </span>
                                    </a>
                                </li>
                                
                            <?php endif; ?>                            
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if($user->can('videoAlbum.view') || $user->can('videoAlbum.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Video Gallery </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.video_album.index') || Route::is('admin.video_album.create') || Route::is('admin.video_album.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('videoAlbum.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.video_album.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.video_album.index') || Route::is('admin.video_album.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Video Album </span>
                                    </a>
                                </li>
                                
                                 <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.video_gallery.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.video_gallery.index') || Route::is('admin.video_gallery.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Video List </span>
                                    </a>
                                </li>
                                
                            <?php endif; ?>                            
                        </ul>
                    </li>
                <?php endif; ?>

                
                <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-tune"></i>
                        <span class="hide-menu">Enquiry List </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.products.index') || Route::is('admin.products.create') || Route::is('admin.products.edit')) ? 'in' : null); ?>">
                        
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.product_enquiry.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.product_enquiry.index') || Route::is('admin.product_enquiry.edit')) ? 'active' : null); ?>">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Products Enquiry List </span>
                            </a>
                        </li>                       
                       
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.instant_offer_enquiry.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.instant_offer_enquiry.index') || Route::is('admin.instant_offer_enquiry.edit')) ? 'active' : null); ?>">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Instant Offer Enquiry List </span>
                            </a>
                        </li> 
                        
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.contactus_enquiry.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.contactus_enquiry.index') || Route::is('admin.contactus_enquiry.edit')) ? 'active' : null); ?>">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Contactus Enquiry List </span>
                            </a>
                        </li> 

                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.newsletter.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.newsletter.index') || Route::is('admin.newsletter.edit')) ? 'active' : null); ?>">
                                <i class="mdi mdi-view-list"></i>
                                <span class="hide-menu"> Newsletter List </span>
                            </a>
                        </li> 
                        

                    </ul>
                </li>
               


                 <?php if($user->can('pages.view') || $user->can('pages.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Static Pages </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.pages.index') || Route::is('admin.pages.create') || Route::is('admin.pages.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('pages.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.pages.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.pages.index') || Route::is('admin.pages.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Pages List </span>
                                    </a>
                                </li>
                            <?php endif; ?>                           
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if($user->can('testimonials.view') || $user->can('testimonials.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Testimonials </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.testimonials.index') || Route::is('admin.testimonials.create') || Route::is('admin.testimonials.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('testimonials.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.testimonials.index') || Route::is('admin.testimonials.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Testimonials List </span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if($user->can('testimonials.create')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="sidebar-link <?php echo e(Route::is('admin.testimonials.create') ? 'active' : null); ?>">
                                        <i class="mdi mdi-plus-circle"></i>
                                        <span class="hide-menu">Post Testimonial </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if($user->can('banners.view') || $user->can('banners.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Banners </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.banners.index') || Route::is('admin.banners.create') || Route::is('admin.banners.edit')  || Route::is('admin.flashes.index') || Route::is('admin.flashes.create') || Route::is('admin.flashes.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('banners.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.banners.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.banners.index') || Route::is('admin.banners.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu">Inner Banners </span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if($user->can('flashes.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.flashes.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.flashes.index') || Route::is('admin.flashes.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu">Flash Banners </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                        </ul>
                    </li>
                <?php endif; ?>

                 <?php if($user->can('faqs.view') || $user->can('faqs.create')): ?>
                    <li class="sidebar-item ">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-view-headline"></i>
                            <span class="hide-menu">Faq's </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.faqs.index') || Route::is('admin.faqs.create') || Route::is('admin.faqs.edit')) ? 'in' : null); ?>">
                            <?php if($user->can('faqs.view')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.faqs.index')); ?>" class="sidebar-link <?php echo e((Route::is('admin.faqs.index') || Route::is('admin.faqs.edit')) ? 'active' : null); ?>">
                                        <i class="mdi mdi-view-list"></i>
                                        <span class="hide-menu"> Faq's List </span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if($user->can('faqs.create')): ?>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.faqs.create')); ?>" class="sidebar-link <?php echo e(Route::is('admin.faqs.create') ? 'active' : null); ?>">
                                        <i class="mdi mdi-plus-circle"></i>
                                        <span class="hide-menu"> New Faq's </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>


                <li class="sidebar-item ">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-settings"></i>
                        <span class="hide-menu">Settings </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level <?php echo e((Route::is('admin.languages.index') || Route::is('admin.languages.create') || Route::is('admin.languages.edit') || Route::is('admin.languages.connection.index')) ? 'in' : null); ?>">                        
                        <li class="sidebar-item">
                            <a href="<?php echo e(route('admin.settings.index')); ?>" class="sidebar-link <?php echo e(( Route::is('admin.settings.index')) ? 'active' : null); ?>">
                                <i class="mdi mdi-account-star"></i>
                                <span class="hide-menu"> Settings </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo e(route('admin.logout')); ?>"  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" aria-expanded="false">
                        <i class="fa fa-power-off"></i>
                        <span class="hide-menu">Log Out</span>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<?php /**PATH E:\wamp64\www\Laravel-HRhelpboard\resources\views/backend/layouts/partials/sidebar.blade.php ENDPATH**/ ?>
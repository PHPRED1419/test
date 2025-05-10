<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\ResetPasswordController;
use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\DashboardsController;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\BlogsController;
use App\Http\Controllers\Backend\ContactsController;
use App\Http\Controllers\Backend\CacheController;
use App\Http\Controllers\Backend\LanguagesController;
use App\Http\Controllers\Backend\SettingsController;

use App\Http\Controllers\Backend\KeywordsController;

use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\ProductsController;
use App\Http\Controllers\Backend\ApplicationsController;
use App\Http\Controllers\Backend\SizesController;
use App\Http\Controllers\Backend\ColorsController; 
use App\Http\Controllers\Backend\BrandsController;
use App\Http\Controllers\Backend\PartsController;

use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\BannersController;
use App\Http\Controllers\Backend\FlashesController;

use App\Http\Controllers\Backend\FaqsController;
use App\Http\Controllers\Backend\TestimonialsController;
use App\Http\Controllers\Backend\BlogsCategoriesController; 

use App\Http\Controllers\Backend\ImageAlbumController; 
use App\Http\Controllers\Backend\ImageGalleryController; 

use App\Http\Controllers\Backend\VideoAlbumController; 
use App\Http\Controllers\Backend\VideoGalleryController; 


use App\Http\Controllers\Backend\ProductEnquiryController; 
use App\Http\Controllers\Backend\InstantOfferEnquiryController; 
use App\Http\Controllers\Backend\ContactusEnquiryController; 
use App\Http\Controllers\Backend\NewsletterController;





/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Admin Panel Route List
|
*/

// Protect the entire admin routes with the 'auth' middleware
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardsController::class, 'index'])->name('index');
    
    // Admin Management Routes
    Route::group(['prefix' => ''], function () {
        Route::resource('admins', AdminsController::class);
        Route::get('admins/trashed/view', [AdminsController::class, 'trashed'])->name('admins.trashed');
        Route::get('profile/edit', [AdminsController::class, 'editProfile'])->name('admins.profile.edit');
        Route::put('profile/update', [AdminsController::class, 'updateProfile'])->name('admins.profile.update');
        Route::delete('admins/trashed/destroy/{id}', [AdminsController::class, 'destroyTrash'])->name('admins.trashed.destroy');
        Route::put('admins/trashed/revert/{id}', [AdminsController::class, 'revertFromTrash'])->name('admins.trashed.revert');  
    });

    
    Route::group(['prefix' => ''], function () {
        Route::resource('categories', CategoriesController::class);
        Route::get('categories/trashed/view', [CategoriesController::class, 'trashed'])->name('categories.trashed');
        Route::delete('categories/trashed/destroy/{id}', [CategoriesController::class, 'destroyTrash'])->name('categories.trashed.destroy');
        Route::put('categories/trashed/revert/{id}', [CategoriesController::class, 'revertFromTrash'])->name('categories.trashed.revert');

        Route::post('categories/delete-multiple', [CategoriesController::class, 'deleteMultiple'])->name('categories.delete.multiple');
    });
    

   // Keywords Management Routes
	Route::group(['prefix' => ''], function () {
		Route::resource('keywords', KeywordsController::class);
		Route::get('keywords/trashed/view', [KeywordsController::class, 'trashed'])->name('keywords.trashed');
		Route::delete('keywords/trashed/destroy/{id}', [KeywordsController::class, 'destroyTrash'])->name('keywords.trashed.destroy');
		Route::put('keywords/trashed/revert/{id}', [KeywordsController::class, 'revertFromTrash'])->name('keywords.trashed.revert');
		Route::post('keywords/delete-multiple', [KeywordsController::class, 'deleteMultiple'])->name('keywords.delete.multiple');
	});

    Route::group(['prefix' => ''], function () {
        Route::resource('blogsCategories', BlogsCategoriesController::class);
        Route::get('blogsCategories/trashed/view', [BlogsCategoriesController::class, 'trashed'])->name('blogsCategories.trashed');
        Route::delete('blogsCategories/trashed/destroy/{id}', [BlogsCategoriesController::class, 'destroyTrash'])->name('blogsCategories.trashed.destroy');
        Route::put('blogsCategories/trashed/revert/{id}', [BlogsCategoriesController::class, 'revertFromTrash'])->name('blogsCategories.trashed.revert');

        Route::post('blogsCategories/delete-multiple', [BlogsCategoriesController::class, 'deleteMultiple'])->name('blogsCategories.delete.multiple');
    });

    
  

Route::group(['prefix' => ''], function () {
    Route::resource('products', ProductsController::class);
    Route::get('products/trashed/view', [ProductsController::class, 'trashed'])->name('products.trashed');
    Route::delete('products/trashed/destroy/{id}', [ProductsController::class, 'destroyTrash'])->name('products.trashed.destroy');
    Route::put('products/trashed/revert/{id}', [ProductsController::class, 'revertFromTrash'])->name('products.trashed.revert');
    Route::post('products/delete-multiple', [ProductsController::class, 'deleteMultiple'])->name('products.delete.multiple');

    Route::post('products/img', [ProductsController::class, 'uploadMedia'])->name('products.upload.media');
    Route::get('products/variants/{id}', [ProductsController::class, 'get_variants'])->name('products.getvariants');
    
    Route::put('products/updateStock/{product_id}', [ProductsController::class, 'updateStock'])->name('products.updateStock');
    Route::get('products/updateStock/{product_id}', [ProductsController::class, 'updateStock'])->name('products.updateStock2');


    Route::get('products/setasservice/{product_id}', [ProductsController::class, 'setAsService'])->name('products.setAsService');
    Route::get('products/unsetasservice/{product_id}', [ProductsController::class, 'unsetAsService'])->name('products.unsetAsService');

    
    
});

// Pages Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('pages', PagesController::class);
    Route::get('pages/trashed/view', [PagesController::class, 'trashed'])->name('pages.trashed');
    Route::delete('pages/trashed/destroy/{id}', [PagesController::class, 'destroyTrash'])->name('pages.trashed.destroy');
    Route::put('pages/trashed/revert/{id}', [PagesController::class, 'revertFromTrash'])->name('pages.trashed.revert');
    Route::post('pages/img', [PagesController::class, 'uploadMedia'])->name('pages.upload.media');
    Route::post('pages/delete-multiple', [PagesController::class, 'deleteMultiple'])->name('pages.delete.multiple');
});

// Faq's Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('faqs', FaqsController::class);
    Route::get('faqs/trashed/view', [FaqsController::class, 'trashed'])->name('faqs.trashed');
    Route::delete('faqs/trashed/destroy/{id}', [FaqsController::class, 'destroyTrash'])->name('faqs.trashed.destroy');
    Route::put('faqs/trashed/revert/{id}', [FaqsController::class, 'revertFromTrash'])->name('faqs.trashed.revert');
    Route::post('faqs/delete-multiple', [FaqsController::class, 'deleteMultiple'])->name('faqs.delete.multiple');
});

// Keywords Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('keywords', KeywordsController::class);
    Route::get('keywords/trashed/view', [KeywordsController::class, 'trashed'])->name('keywords.trashed');
    Route::delete('keywords/trashed/destroy/{id}', [KeywordsController::class, 'destroyTrash'])->name('keywords.trashed.destroy');
    Route::put('keywords/trashed/revert/{id}', [KeywordsController::class, 'revertFromTrash'])->name('keywords.trashed.revert');
    Route::post('keywords/delete-multiple', [KeywordsController::class, 'deleteMultiple'])->name('keywords.delete.multiple');
});


// Blog Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('blogs', BlogsController::class);
    Route::get('blogs/trashed/view', [BlogsController::class, 'trashed'])->name('blogs.trashed');
    Route::delete('blogs/trashed/destroy/{id}', [BlogsController::class, 'destroyTrash'])->name('blogs.trashed.destroy');
    Route::put('blogs/trashed/revert/{id}', [BlogsController::class, 'revertFromTrash'])->name('blogs.trashed.revert');
    Route::post('blogs/delete-multiple', [BlogsController::class, 'deleteMultiple'])->name('blogs.delete.multiple');
});

// Testimonials Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('testimonials', TestimonialsController::class);
    Route::get('testimonials/trashed/view', [TestimonialsController::class, 'trashed'])->name('testimonials.trashed');
    Route::delete('testimonials/trashed/destroy/{id}', [TestimonialsController::class, 'destroyTrash'])->name('testimonials.trashed.destroy');
    Route::put('testimonials/trashed/revert/{id}', [TestimonialsController::class, 'revertFromTrash'])->name('testimonials.trashed.revert');
    Route::post('testimonials/delete-multiple', [TestimonialsController::class, 'deleteMultiple'])->name('testimonials.delete.multiple');
});

// Size Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('sizes', SizesController::class);
    Route::get('sizes/trashed/view', [SizesController::class, 'trashed'])->name('sizes.trashed');
    Route::delete('sizes/trashed/destroy/{id}', [SizesController::class, 'destroyTrash'])->name('sizes.trashed.destroy');
    Route::put('sizes/trashed/revert/{id}', [SizesController::class, 'revertFromTrash'])->name('sizes.trashed.revert');
    Route::post('sizes/delete-multiple', [SizesController::class, 'deleteMultiple'])->name('sizes.delete.multiple');
});

// Color Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('colors', ColorsController::class);
    Route::get('colors/trashed/view', [ColorsController::class, 'trashed'])->name('colors.trashed');
    Route::delete('colors/trashed/destroy/{id}', [ColorsController::class, 'destroyTrash'])->name('colors.trashed.destroy');
    Route::put('colors/trashed/revert/{id}', [ColorsController::class, 'revertFromTrash'])->name('colors.trashed.revert');
    Route::post('colors/delete-multiple', [ColorsController::class, 'deleteMultiple'])->name('colors.delete.multiple');
});

// Brand Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('brands', BrandsController::class);
    Route::get('brands/trashed/view', [BrandsController::class, 'trashed'])->name('brands.trashed');
    Route::delete('brands/trashed/destroy/{id}', [BrandsController::class, 'destroyTrash'])->name('brands.trashed.destroy');
    Route::put('brands/trashed/revert/{id}', [BrandsController::class, 'revertFromTrash'])->name('brands.trashed.revert');
    Route::post('brands/delete-multiple', [BrandsController::class, 'deleteMultiple'])->name('brands.delete.multiple');
});

// Banner Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('banners', BannersController::class);
    Route::get('banners/trashed/view', [BannersController::class, 'trashed'])->name('banners.trashed');
    Route::delete('banners/trashed/destroy/{id}', [BannersController::class, 'destroyTrash'])->name('banners.trashed.destroy');
    Route::put('banners/trashed/revert/{id}', [BannersController::class, 'revertFromTrash'])->name('banners.trashed.revert');
    Route::post('banners/delete-multiple', [BannersController::class, 'deleteMultiple'])->name('banners.delete.multiple');
});

// Banner Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('flashes', FlashesController::class);
    Route::get('flashes/trashed/view', [FlashesController::class, 'trashed'])->name('flashes.trashed');
    Route::delete('flashes/trashed/destroy/{id}', [FlashesController::class, 'destroyTrash'])->name('flashes.trashed.destroy');
    Route::put('flashes/trashed/revert/{id}', [FlashesController::class, 'revertFromTrash'])->name('flashes.trashed.revert');
    Route::post('flashes/delete-multiple', [FlashesController::class, 'deleteMultiple'])->name('flashes.delete.multiple');
});

// Part Management Routes
Route::group(['prefix' => ''], function () {
    Route::resource('parts', PartsController::class);
    Route::get('parts/trashed/view', [PartsController::class, 'trashed'])->name('parts.trashed');
    Route::delete('parts/trashed/destroy/{id}', [PartsController::class, 'destroyTrash'])->name('parts.trashed.destroy');
    Route::put('parts/trashed/revert/{id}', [PartsController::class, 'revertFromTrash'])->name('parts.trashed.revert');
    Route::post('parts/delete-multiple', [PartsController::class, 'deleteMultiple'])->name('parts.delete.multiple');
});

Route::group(['prefix' => ''], function () {
    Route::resource('image_album', ImageAlbumController::class);
    Route::get('image_album/trashed/view', [ImageAlbumController::class, 'trashed'])->name('image_album.trashed');
    Route::delete('image_album/trashed/destroy/{id}', [ImageAlbumController::class, 'destroyTrash'])->name('image_album.trashed.destroy');
    Route::put('image_album/trashed/revert/{id}', [ImageAlbumController::class, 'revertFromTrash'])->name('image_album.trashed.revert');

    Route::post('image_album/delete-multiple', [ImageAlbumController::class, 'deleteMultiple'])->name('image_album.delete.multiple');
});

Route::group(['prefix' => ''], function () {
    Route::resource('image_gallery', ImageGalleryController::class);
    Route::get('image_gallery/trashed/view', [ImageGalleryController::class, 'trashed'])->name('image_gallery.trashed');
    Route::delete('image_gallery/trashed/destroy/{id}', [ImageGalleryController::class, 'destroyTrash'])->name('image_gallery.trashed.destroy');
    Route::put('image_gallery/trashed/revert/{id}', [ImageGalleryController::class, 'revertFromTrash'])->name('image_gallery.trashed.revert');

    Route::post('image_gallery/delete-multiple', [ImageGalleryController::class, 'deleteMultiple'])->name('image_gallery.delete.multiple');
});


Route::group(['prefix' => ''], function () {
    Route::resource('video_album', VideoAlbumController::class);
    Route::get('video_album/trashed/view', [VideoAlbumController::class, 'trashed'])->name('video_album.trashed');
    Route::delete('video_album/trashed/destroy/{id}', [VideoAlbumController::class, 'destroyTrash'])->name('video_album.trashed.destroy');
    Route::put('video_album/trashed/revert/{id}', [VideoAlbumController::class, 'revertFromTrash'])->name('video_album.trashed.revert');

    Route::post('video_album/delete-multiple', [VideoAlbumController::class, 'deleteMultiple'])->name('video_album.delete.multiple');
});

Route::group(['prefix' => ''], function () {
    Route::resource('video_gallery', VideoGalleryController::class);
    Route::get('video_gallery/trashed/view', [VideoGalleryController::class, 'trashed'])->name('video_gallery.trashed');
    Route::delete('video_gallery/trashed/destroy/{id}', [VideoGalleryController::class, 'destroyTrash'])->name('video_gallery.trashed.destroy');
    Route::put('video_gallery/trashed/revert/{id}', [VideoGalleryController::class, 'revertFromTrash'])->name('video_gallery.trashed.revert');

    Route::post('video_gallery/delete-multiple', [VideoGalleryController::class, 'deleteMultiple'])->name('video_gallery.delete.multiple');
});



Route::group(['prefix' => ''], function () {
    Route::resource('product_enquiry', ProductEnquiryController::class);
    Route::post('product_enquiry/delete-multiple', [ProductEnquiryController::class, 'deleteMultiple'])->name('product_enquiry.delete.multiple');
});

Route::group(['prefix' => ''], function () {
    Route::resource('instant_offer_enquiry', InstantOfferEnquiryController::class);
    Route::post('instant_offer_enquiry/delete-multiple', [InstantOfferEnquiryController::class, 'deleteMultiple'])->name('instant_offer_enquiry.delete.multiple');
});

Route::group(['prefix' => ''], function () {
    Route::resource('contactus_enquiry', ContactusEnquiryController::class);
    Route::post('contactus_enquiry/delete-multiple', [ContactusEnquiryController::class, 'deleteMultiple'])->name('contactus_enquiry.delete.multiple');
});

Route::group(['prefix' => ''], function () {
    Route::resource('newsletter', NewsletterController::class);
    Route::get('newsletter/show/{id}', [NewsletterController::class, 'show'])->name('newsletter.show');
    Route::post('newsletter/delete-multiple', [NewsletterController::class, 'deleteMultiple'])->name('newsletter.delete.multiple');
});


    // Role & Permission Management Routes
    Route::group(['prefix' => ''], function () {
        Route::resource('roles', RolesController::class);
    });

    // Contact Routes
    Route::group(['prefix' => ''], function () {
        Route::resource('contacts', ContactusEnquiryController::class);
        Route::get('contact_enquiry/show/{id}', [ContactusEnquiryController::class, 'show'])->name('contact_enquiry.show');
    });

    // Settings Management Routes
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/update', [SettingsController::class, 'update'])->name('settings.update');
        Route::resource('languages', LanguagesController::class);
        Route::get('/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear.cache');
    });

    //Route::get('reset-cache', [CacheController::class, 'reset_cache']);
});

// Login Routes (outside the auth middleware)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout/submit', [LoginController::class, 'logout'])->name('logout');

// Reset Password Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');






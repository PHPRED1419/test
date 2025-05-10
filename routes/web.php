<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;
use Modules\Pages\Http\Controllers\PagesController;
use Modules\Category\Http\Controllers\CategoryController;

use Modules\Product\Http\Controllers\ProductController;
use Modules\Service\Http\Controllers\ServiceController;

use Modules\Acategory\Http\Controllers\AcategoryController;
use Modules\Aproduct\Http\Controllers\AproductController;
use Modules\BlogCategory\Http\Controllers\BlogCategoryController;
use Modules\Blogs\Http\Controllers\BlogsController;  

use Modules\ImageAlbum\Http\Controllers\ImageAlbumController;  
use Modules\VideoAlbum\Http\Controllers\VideoAlbumController;

use Modules\ImageGallery\Http\Controllers\ImageGalleryController; 
use Modules\VideoGallery\Http\Controllers\VideoGalleryController; 

use Modules\Testimonials\Http\Controllers\TestimonialsController; 

//use Modules\Testimonials\Http\Controllers\KeywordsController; 

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CKEditorController;
//use App\Http\Controllers\ColorController;

/*
|--------------------------------------------------------------------------
| Web Routes - Frontend routes.
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get( '/', [ HomeController::class, 'index' ] )->name( 'index' );
Route::get('/about-us', [PagesController::class, 'index'])->name('index.aboutus');
Route::get('/vision-mission', [PagesController::class, 'index'])->name('index.vision');
Route::get('/cookies-policy', [PagesController::class, 'index'])->name('index.cookies');
Route::get('/privacy-policy', [PagesController::class, 'index'])->name('index.privacy');
Route::get('/legal-disclaimer', [PagesController::class, 'index'])->name('index.legal');
Route::get('/terms-conditions', [PagesController::class, 'index'])->name('index.terms');
Route::get('/sitemap', [PagesController::class, 'sitemap'])->name('index.sitemap');



// Remove the prefix group and define routes directly
Route::get('/human-resource.html', [CategoryController::class, 'humanResource'])
     ->name('categories.human_resource');

Route::get('/human-resource/{slug}', [CategoryController::class, 'showResource'])
     ->name('categories.human_resource.subpage');









Route::post('/newsletter/subscribe', [PagesController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/refresh-captcha', [NewsletterController::class, 'refreshCaptcha'])->name('refresh.captcha');



Route::get('/contact-us', [PagesController::class, 'contact_us'])->name('index.contact_us');
Route::post('/contact-us', [PagesController::class, 'contact_us_submit'])->name('contact_us.submit');

Route::get('/testimonials', [TestimonialsController::class, 'index'])->name('testimonials');
Route::post('/testimonials', [TestimonialsController::class, 'store'])->name('testimonials.store');
Route::get('/refresh-captcha', [TestimonialsController::class, 'refreshCaptcha'])->name('refresh.captcha');

//Route::get('/Keywords', [KeywordsController::class, 'index'])->name('Keywords');

Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('admin.ckeditor.upload');
//Route::get('/color-name', [ColorController::class, 'getColorName']);


Route::get('/category/{slug}', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/products/details/{slug}', [ProductController::class, 'show'])->name('products.details');
Route::get('/products/search_products', [ProductController::class, 'search_products'])
->name('products.search_products');

Route::get('/products/{slug?}', [ProductController::class, 'index'])->name('products.index');

Route::get('/services/', [ServiceController::class, 'index'])->name('services.index');

Route::get('/acategory/{slug}', [AcategoryController::class, 'index'])->name('acategories.index');
Route::get('/aproducts/{slug?}', [AproductController::class, 'index'])->name('aproducts.index');
Route::get('/aproducts/details/{slug}', [AproductController::class, 'show'])->name('aproducts.details');


Route::post('/products/enquiry', [ProductController::class, 'submitEnquiry'])->name('products.enquiry.submit');
Route::get('/instant-offer', [ProductController::class, 'instant_offer'])->name('products.instant_offer');
Route::post('/products/offerEnquiry', [ProductController::class, 'submitOfferEnquiry'])->name('submit.instant.offer');


Route::get('/blogCategory', [BlogCategoryController::class, 'index'])->name('blogCategory.index');
Route::get('/blogs/{slug}', [BlogsController::class, 'index'])->name('blogs.index');
Route::get('/blogs/details/{slug}', [BlogsController::class, 'show'])->name('blogs.details');

Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');

Route::get('/image-album', [ImageAlbumController::class, 'index'])->name('image_album.index');
Route::get('/video-album', [VideoAlbumController::class, 'index'])->name('video_album.index');

Route::get('/image-gallery/{slug}', [ImageGalleryController::class, 'index'])->name('image_gallery.index');
Route::get('/video-gallery/{slug}', [VideoGalleryController::class, 'index'])->name('video_gallery.index');


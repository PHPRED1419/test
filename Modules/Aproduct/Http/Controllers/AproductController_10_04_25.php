<?php

namespace Modules\Aproduct\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
//use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Modules\Acategory\Entities\Acategory;
use Modules\Aproduct\Entities\Aproduct;
use Illuminate\Support\Facades\DB; 
//use App\Models\ApplicationsCategories;

class AproductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {       
        $categorySlug = request()->segment(2);      
        $query = Aproduct::query()
        ->leftJoin('wl_applications_media', function($join) {
            $join->on('wl_applications.applications_id', '=', 'wl_applications_media.applications_id')
                ->where('wl_applications_media.is_default', '=', 'Y');
        })
        ->select('wl_applications.*', 'wl_applications_media.media');

        if ($categorySlug) {
            $category = Acategory::where('slug', $categorySlug)->first();

            if ($category) {
                $query->where('wl_applications.category_id', $category->id);
            }
        }

        $products = $query->get();

        // Get categories with their subcategories
    $categories = Acategory::parentCategories()
    ->with(['subcategories'])
    ->get();       
        return view('aproduct::index', compact('products','categories'));
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
   // app/Http/Controllers/ProductController.php

    public function show($slug)
    {
        $product = Aproduct::where('slug', $slug)
        ->leftJoin('wl_applications_media', function($join) {
            $join->on('wl_applications.applications_id', '=', 'wl_applications_media.applications_id')
                ->where('wl_applications_media.is_default', '=', 'Y');
        })
        ->firstOrFail();
       
        $media = DB::table('wl_applications_media')
            ->where('applications_id', $product->applications_id)
            ->get();
        //dd($product);
        return view('aproduct::details', [
            'product' => $product,
            'media' => $media
        ]);
    }

}

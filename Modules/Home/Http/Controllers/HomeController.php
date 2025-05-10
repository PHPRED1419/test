<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Home\Entities\Testimonials;
use Modules\Pages\Entities\Pages;
use Modules\Product\Entities\Product;
use Modules\Aproduct\Entities\Aproduct;
use App\Models\ImageAlbum;
use App\Models\ImageGallery;
use App\Models\VideoAlbum;
use App\Models\VideoGallery;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {         
        $home_page_contents = Pages::where('id', 7)->first(); 
        
        $query = Product::query()
        ->leftJoin('wl_products_media', function($join) {
            $join->on('wl_products.products_id', '=', 'wl_products_media.products_id')
                ->where('wl_products_media.is_default', '=', 'Y');
        })
        ->select('wl_products.*', 'wl_products_media.media')
        ->where('status', 1)
        ->take(12);
        $products = $query->get();

        $query2 = Aproduct::query()
        ->leftJoin('wl_applications_media', function($join) {
            $join->on('wl_applications.applications_id', '=', 'wl_applications_media.applications_id')
                ->where('wl_applications_media.is_default', '=', 'Y');
        })
        ->select('wl_applications.*', 'wl_applications_media.media')
        ->take(12);
        $applications = $query2->get();
        
        /*$query3 = ImageGallery::query()
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc');        
        $gallery = $query3->paginate(2);

        $query4 = VideoGallery::query()
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc');        
        $vgallery = $query4->paginate(2); 
        */

        $image_album = ImageAlbum::where('status', 1)               
        ->orderBy('created_at', 'desc')
        ->paginate(3);

        $video_album = VideoAlbum::where('status', 1)               
        ->orderBy('created_at', 'desc')
        ->paginate(3);

        return view('home::index',compact('home_page_contents','products','applications','image_album','video_album'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('home::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('home::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('home::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace Modules\VideoGallery\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\VideoAlbum;
use App\Models\VideoGallery;

class VideoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {  
        $categorySlug = $request->segment(2);
        $query = VideoGallery::query()
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc');
        if ($categorySlug) {
            $category = VideoAlbum::where('slug', $categorySlug)->first();            
            if ($category) {
                $query->where('category_id', $category->category_id);
            }
        }
        $category_name = $category['category_name'];
        $gallery = $query->paginate(100);        
        return view('videogallery::index',compact('gallery','category_name'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('imagealbum::create');
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
        return view('imagealbum::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('imagealbum::edit');
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

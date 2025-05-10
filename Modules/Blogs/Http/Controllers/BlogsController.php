<?php

namespace Modules\Blogs\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Blog;
use App\Models\BlogsCategories;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $categorySlug = $request->segment(2);
        $query = Blog::query()
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc');
        if ($categorySlug) {
            $category = BlogsCategories::where('slug', $categorySlug)->first();
            
            if ($category) {
                $query->where('category_id', $category->category_id);
            }
        }
        $category_name = $category['category_name'] ?? '';
        $blogs = $query->paginate(25);
        return view('blogs::index', compact('blogs', 'categorySlug','category_name'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('blogs::create');
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
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
        ->firstOrFail();

       //$blog->category_id; 
        $category_res = BlogsCategories::find($blog->category_id);

        $categories = BlogsCategories::query()
            ->orderBy('created_at', 'desc')
            ->paginate(50);
      
        return view('blogs::details', [
            'blog' => $blog,
            'categories' => $categories,
            'category_name' => $category_res['category_name']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blogs::edit');
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

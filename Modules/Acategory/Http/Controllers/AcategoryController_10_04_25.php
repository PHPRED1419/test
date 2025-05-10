<?php

namespace Modules\Acategory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ApplicationsCategories;

class AcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($slug = null)
    {
        
        if ($slug) {
            $category = ApplicationsCategories::where('slug', $slug)->firstOrFail();
            $data = getSubAcategoriesByParentSlug($slug, ['products']);            
        } else {
            $data = ApplicationsCategories::where('status', 1)
                ->where('parent_category_id', null)
				->orderBy('priority', 'DESC')
                ->get();
        }

        if ($data->isNotEmpty()) {
            return view('acategory::index', compact('data'));
        }
        
        // Redirect to products page with category filter       
        return redirect()->route('aproducts.index', ['slug' => $slug]);
        
       // return view('acategory::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('acategory::create');
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
        return view('acategory::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('acategory::edit');
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

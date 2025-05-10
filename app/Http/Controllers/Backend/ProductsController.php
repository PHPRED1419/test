<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Part;

use App\Models\ProductMedia;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductStock;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($isTrashed = false)
    {
        // Check user permissions
        if (is_null($this->user) || !$this->user->can('product.view')) {
            $message = 'You are not allowed to access this page!';
            return view('errors.403', compact('message'));
        }
    
        // Define fields and conditions
        $fields = 'wlp.*';
        $rev_cond = 'status=1 AND ';
        $color_id = request('color_id'); 
        $size_id = request('size_id'); 
        $color_ids = request('color_ids'); 
        $size_ids = request('size_ids'); 
    
        // Build the query
        $data_res = DB::table('wl_products as wlp')
            ->select(DB::raw("SQL_CALC_FOUND_ROWS {$fields}, 
                wlp.status as product_status, 
                wlpm.media, 
                wlpm.media_type, 
                wlpm.is_default, 
                (SELECT COUNT(review_id) 
                 FROM wl_review 
                 WHERE {$rev_cond} prod_id = wlp.products_id 
                 AND rev_type = 'P') AS review_count, 
                IF(product_discounted_price = 0, product_price, product_discounted_price) AS price, 
                (SELECT bnd.brand_name 
                 FROM wl_brands AS bnd 
                 WHERE wlp.brand_id = bnd.brand_id) AS brand_name"))
            ->leftJoin('wl_products_media as wlpm', 'wlp.products_id', '=', 'wlpm.products_id')
            ->where('wlp.status', '!=', '2');
    
        // Apply filters
        if (isset($color_id)) {
            $data_res->join('wl_product_colors as wlc', 'wlp.products_id', '=', 'wlc.product_id')
                ->where('wlc.color_id', '=', $color_id);
        }
    
        if (isset($color_ids)) {
            $data_res->join('wl_product_colors as wlc', 'wlp.products_id', '=', 'wlc.product_id')
                ->whereIn('wlc.color_id', explode(',', $color_ids));
        }
    
        if (isset($size_id)) {
            $data_res->join('wl_product_sizes as wls', 'wlp.products_id', '=', 'wls.product_id')
                ->where('wls.size_id', '=', $size_id);
        }
    
        if (isset($size_ids)) {
            $data_res->join('wl_product_sizes as wls', 'wlp.products_id', '=', 'wls.product_id')
                ->whereIn('wls.size_id', explode(',', $size_ids));
        }
    
       
        if (request()->ajax()) {
            
            if ($isTrashed) {
                $products = $data_res->orderBy('wlp.products_id', 'desc')
                    ->where('wlp.status', '0')                     
                    ->groupBy('wlp.products_id')
                    ->get();
            } else {
                $products = $data_res->orderBy('wlp.products_id', 'desc') 
                    //->whereNull('wlp.deleted_at')                  
                    ->where('wlp.status', '1') 
                    ->groupBy('wlp.products_id')
                    ->get();
            }
            
            //$sql = $data_res->toSql();
            //$bindings = $data_res->getBindings();
            //dd($sql, $bindings);

            // Build DataTable response
            $datatable = DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->products_id . '">';
                })
                ->addColumn('action', function ($row) use ($isTrashed) {
                    $csrf = csrf_field();
                    $method_delete = method_field('delete');
                    $method_put = method_field('put');
                    $html = '';
    
                    if ($row->deleted_at === null) {
                        $deleteRoute = route('admin.products.destroy', [$row->products_id]);
                        if ($this->user->can('product.edit')) {
                            $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle" title="Edit Product" href="' . route('admin.products.edit', $row->products_id) . '"><i class="fa fa-edit"></i></a>';
                        }
                        if ($this->user->can('product.delete')) {
                            $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-2 text-white" title="Delete Product" id="deleteItem' . $row->products_id . '"><i class="fa fa-trash"></i></a>';
                        }
                    } elseif ($this->user->can('product.delete')) {
                        $deleteRoute = route('admin.products.trashed.destroy', [$row->products_id]);
                        $revertRoute = route('admin.products.trashed.revert', [$row->products_id]);
    
                        $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle" title="Revert Back" id="revertItem' . $row->products_id . '"><i class="fa fa-check"></i></a>';
                        $html .= '<form id="revertForm' . $row->products_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i class="fa fa-check"></i> Confirm Revert</button>
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        </form>';
                        $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-2 text-white" title="Delete Permanently" id="deleteItemPermanent' . $row->products_id . '"><i class="fa fa-trash"></i></a>';
                    }
    
                    // Add JavaScript for confirmation dialogs
                    $html .= '<script>
                        $("#deleteItem' . $row->products_id . '").click(function() {
                            swal.fire({ title: "Are you sure?", text: "Product will be deleted as trashed!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!" })
                                .then((result) => { if (result.value) { $("#deleteForm' . $row->products_id . '").submit(); } });
                        });
                        $("#deleteItemPermanent' . $row->products_id . '").click(function() {
                            swal.fire({ title: "Are you sure?", text: "Product will be deleted permanently!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!" })
                                .then((result) => { if (result.value) { $("#deletePermanentForm' . $row->products_id . '").submit(); } });
                        });
                        $("#revertItem' . $row->products_id . '").click(function() {
                            swal.fire({ title: "Are you sure?", text: "Product will be reverted from trash!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, revert it!" })
                                .then((result) => { if (result.value) { $("#revertForm' . $row->products_id . '").submit(); } });
                        });
                    </script>';
    
                    // Add delete forms
                    $html .= '
                    <form id="deleteForm' . $row->products_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i class="fa fa-check"></i> Confirm Delete</button>
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </form>
                    <form id="deletePermanentForm' . $row->products_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i class="fa fa-check"></i> Confirm Permanent Delete</button>
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </form>                     
                    ';
                    
                    $html .= $row->product_type == '1' ? '<h3 class="text-success" style="font-size: 17px;margin-top: 11px; color: black !important;"><i class="fa fa-check-circle"></i> Product</h3>' : '<h3 class="text-success" style="font-size: 17px;margin-top: 11px; color: brown !important;"><i class="fa fa-check-circle"></i> Service</h3>';

                /*$html .= '<button type="button" class="btn btn-primary custom-modal-botton" data-toggle="modal" data-target="#exampleModal" onclick="loadModalData(' . $row->products_id . ', \'' . $row->product_name . '\', \'' . $row->product_code . '\')">Update Stock</button>';
                */
    
                    return $html;
                })
                ->editColumn('product_name', function ($row) {   
                    $html = '';
                    if($row->status == '1'){
                            if($row->product_type=='1'){
                                $setAsServiceRoute = 'products/setasservice/'.$row->products_id;
                                $html .= $row->product_name.'<br /><a href="'.$setAsServiceRoute.'" class="" style="">Set As Service</a>';
                            }

                            if($row->product_type=='2'){
                                $unsetAsServiceRoute = 'products/unsetasservice/'.$row->products_id;
                                $html .= $row->product_name.'<br /><a href="'.$unsetAsServiceRoute.'" class="" style="">Unset As Service</a>';
                            }
                    }else{                        
                             $html .= $row->product_name.'<br />';
                    }

                    return $html;
                })
                ->editColumn('product_code', function ($row) {
                    return $row->product_code;
                })               
                ->editColumn('media', function ($row) {
                    if ($row->media) {
                        return '
                        <div id="img-viewer">
                            <span class="close" onclick="close_model()">&times;</span>
                            <img class="modal-content" id="full-image">
                        </div>
                        <div class="img-container">
                            <img src="' . asset('assets/images/products/' . $row->media) . '" class="img img-display-list img-source" onclick="full_view(this);" style="width:100px;">
                        </div>';
                    }
                    return '-';
                })              
               
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success font-weight-100">Active</span>';
                    } elseif ($row->deleted_at) {
                        return '<span class="badge badge-danger">Trashed</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->rawColumns(['checkbox', 'action', 'product_name', 'product_code','status', 'priority', 'media'])
                ->make(true);

            return $datatable;
           
        }
        
        // Get counts for the view
        $count_products = Product::count();
        $count_active_products = Product::where('status', '1')->count();
        $count_trashed_products = Product::whereNotNull('deleted_at')->count();

        return view('backend.products.index', compact('count_products', 'count_active_products', 'count_trashed_products'));
    }

    public function setasservice($product_id)
    {  
        $affectedRows = Product::where('products_id', $product_id)
            ->update([
                'product_type' => '2'
        ]);

        session()->flash('success', 'Product Set as Service successfully!');
        return redirect()->route('admin.products.index');       
    }

    public function unsetasservice($product_id)
    {  
        $affectedRows = Product::where('products_id', $product_id)
            ->update([
                'product_type' => '1'
        ]);

        session()->flash('success', 'Product Unset as Service successfully!');
        return redirect()->route('admin.products.index');       
    }

       

    public function deleteMultiple(Request $request)
    {
        // Check user permissions
        if (is_null($this->user) || !$this->user->can('product.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to access this page!',
            ], 403); // 403 Forbidden
        }

        // Get the IDs from the request
        $ids = $request->input('ids');

        // Validate the input
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No product IDs provided!',
            ], 400); // 400 Bad Request
        }

        // Use a transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Delete related records in the correct order
            ProductMedia::whereIn('products_id', $ids)->delete();
            ProductColor::whereIn('product_id', $ids)->delete();
            ProductSize::whereIn('product_id', $ids)->delete();
            Product::whereIn('products_id', $ids)->delete();

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Products and related records deleted successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error deleting products: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the products!',
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $product = new Product();
        //$brands = Brand::select('brand_id', 'brand_name')->where('status','1')->get();
        //$models = Part::select('part_id', 'part_name')->where('status','1')->get();
        //$sizes = Size::select('size_id', 'size_name')->where('status','1')->get();
       // $colors = Color::select('color_id', 'color_name', 'color_code')->where('status','1')->get();        
        
        $image_counter = config('constants.NO_OF_PRODUCT_IMAGES');
        return view('backend.products.create', compact('product','image_counter'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 

    public function store(Request $request)
    {
        // Check user permissions
        if (is_null($this->user) || !$this->user->can('product.create')) {
            return abort(403, 'You are not allowed to access this page!');
        }
    
        // Validate the request
        $request->validate([
            'parent_category_id' => 'required',
            'product_name' => 'required|max:100|unique:wl_products,product_name',
            'slug' => 'nullable|max:100|unique:wl_products,slug',
            'product_code' => 'required|max:100|unique:wl_products,product_code',
            //'product_type' => 'required|max:5',
           // 'product_price' => 'required|numeric|min:0',
            //'product_discounted_price' => 'nullable|numeric|min:0',
            'products_description' => 'nullable|string',
            'products_specification' => 'nullable|string',
            'product_images*' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:500', // Validate each image
        ]);
    
        // Begin database transaction
        DB::beginTransaction();
        
        $product = new Product();    

        try {
            echo $image_counter = config('constants.NO_OF_PRODUCT_IMAGES');

            if ($request->slug) {
                $product->slug = $request->slug;  
            } else {                           
                $product->slug = StringHelper::createSlug($request->product_name, 'Product', 'slug', '-');   
            }
            
            // Create a new product
           
            $product->fill([
                'product_type' => 1,
                'product_name' => $request->product_name,
                'product_code' => $request->product_code,               
                'category_id' => $request->parent_category_id,
                'product_price' => $request->product_price,
                'product_discounted_price' => $request->product_discounted_price ?? 0,
                'brand_id' => $request->brand_id ?? 0,
                'part_id' => $request->part_id ?? 0,
                'product_alt' => $request->product_alt ?? '',
                'products_description' => $request->products_description,
                'products_specification' => $request->products_specification,

                'product_size_ids' => !empty($request->size_id) ? implode(",", $request->size_id) : null,
                'product_color_ids' => !empty($request->color_id) ? implode(",", $request->color_id) : null,
                'status' => $request->status ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $product->save();
    
            // Update priority based on the last product's priority
            $lastProductPriorityValue = Product::orderBy('priority', 'desc')->value('priority');
            if (!is_null($lastProductPriorityValue)) {
                $product->priority = (int) $lastProductPriorityValue + 1;
                $product->save();
            }
    
            // Upload size chart image if provided
            if ($request->hasFile('product_sizechart_image')) {
                $product->product_sizechart_image = UploadHelper::upload(
                    'product_sizechart_image',
                    $request->file('product_sizechart_image'),
                    'product_sizechart-' . time(),
                    'public/assets/images/products'
                );
                $product->save();
            }
    
          
            $processed_images = [];

            for ($i = 1; $i <= $image_counter; $i++) {
                $input_name = 'product_images_' . $i;
                $existing_media_name = 'existing_media_' . $i;

                if ($request->hasFile($input_name)) {
                    if ($request->$existing_media_name) {
                        UploadHelper::delete('assets/images/products/' . $request->$existing_media_name);
                    }

                    // Upload the new media
                    $media = UploadHelper::upload(
                        $input_name,
                        $request->file($input_name),
                        'product_images-' . $product->products_id . '-' . $i . '-' . time(),
                        'assets/images/products'
                    );

                    // Create new media record (don't update existing)
                    $productMedia = ProductMedia::create([
                        'products_id' => $product->products_id,
                        'media_type' => 'photo',
                        'media' => $media,
                        'is_default' => $i === 1 ? 'Y' : 'N',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $processed_images[] = $productMedia->id;

                } elseif ($request->$existing_media_name) {
                    // Find existing media record for this position
                    $existingMedia = ProductMedia::where('products_id', $product->products_id)
                        ->where('media', $request->$existing_media_name)
                        ->first();

                    if ($existingMedia) {
                        $existingMedia->update([
                            'is_default' => $i === 1 ? 'Y' : 'N',
                            'updated_at' => Carbon::now(),
                        ]);
                        $processed_images[] = $existingMedia->id;
                    }
                }
            }

            // Delete any media records that weren't processed (removed by user)
            if (!empty($processed_images)) {
                ProductMedia::where('products_id', $product->products_id)
                    ->where('media_type', 'photo')
                    ->whereNotIn('id', $processed_images)
                    ->delete();
            }
    
            $productId = $product->products_id;
    
            // Insert product sizes
            if (is_array($request->size_id)) {
                $sizes_data = array_map(function ($size_id) use ($productId) {
                    return [
                        'size_id' => $size_id,
                        'product_id' => $productId,
                    ];
                }, $request->size_id);
                DB::table('wl_product_sizes')->insert($sizes_data);
            }
    
            // Insert product colors
            if (is_array($request->color_id)) {
                $colors_data = array_map(function ($color_id) use ($productId) {
                    return [
                        'color_id' => $color_id,
                        'product_id' => $productId,
                    ];
                }, $request->color_id);
                DB::table('wl_product_colors')->insert($colors_data);
            }
    
            // Insert low stock data
            $productSizes = $request->size_id ?? [];
            $productColors = $request->color_id ?? [];
    
            if (!empty($productSizes) || !empty($productColors)) {
                $sizeString = implode(',', $productSizes);
                $colorString = implode(',', $productColors);
    
                // Delete existing stock entries not in the current selection
                DB::table('wl_product_stock')
                    ->where('product_id', $productId)
                    ->where(function ($query) use ($sizeString, $colorString) {
                        $query->whereNotIn('product_size', explode(',', $sizeString))
                              ->orWhereNotIn('product_color', explode(',', $colorString));
                    })
                    ->delete();
    
                // Insert new stock entries
                foreach ($productSizes as $size) {
                    foreach ($productColors as $color) {
                        DB::table('wl_product_stock')->updateOrInsert(
                            [
                                'product_id' => $productId,
                                'product_size' => $size,
                                'product_color' => $color,
                            ],
                            ['product_quantity' => 0]
                        );
                    }
                }
            } else {
                // Insert default stock entry if no sizes or colors are selected
                DB::table('wl_product_stock')->updateOrInsert(
                    [
                        'product_id' => $productId,
                        'product_size' => 0,
                        'product_color' => 0,
                    ],
                    ['product_quantity' => 0]
                );
            }
    
            // Log the action
            Track::newTrack($product->product_name, 'New Product has been created');
    
            // Commit the transaction
            DB::commit();
    
            session()->flash('success', 'New Product has been created successfully!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            session()->flash('sticky_error', $e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('category.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $image_counter = config('constants.NO_OF_PRODUCT_IMAGES');
        $product   = Product::find($id);
        $medias = ProductMedia::where('products_id', $id)->get();

        //$brands = Brand::select('brand_id', 'brand_name')->where('status','1')->get();
        //$models = Part::select('part_id', 'part_name')->where('status','1')->get();
        //$sizes = Size::select('size_id', 'size_name')->where('status','1')->get();
        //$colors = Color::select('color_id', 'color_name', 'color_code')->where('status','1')->get();        
        
        return view('backend.products.edit', compact('product','medias','image_counter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   

        // Check user permissions
        if (is_null($this->user) || !$this->user->can('product.edit')) {
            return abort(403, 'You are not allowed to access this page!');
        }

        // Validate the request
        $request->validate([
            'parent_category_id' => 'required',
            'product_name' => 'required|max:100|unique:wl_products,product_name,' . $id . ',products_id', 
            'slug' => 'nullable|max:100|unique:wl_products,slug,' . $id . ',products_id', 
            'product_code' => 'required|max:100|unique:wl_products,product_code,' . $id . ',products_id',  
            //'product_type' => 'required|max:5',
           // 'product_price' => 'required|numeric|min:0',
           // 'product_discounted_price' => 'nullable|numeric|min:0',
            'products_description' => 'nullable|string', 
            'products_specification' => 'nullable|string',
            'product_images*' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:500', 
        ]);

        // Begin database transaction
        DB::beginTransaction();

        try {
            $image_counter = config('constants.NO_OF_PRODUCT_IMAGES');
            $medias = ProductMedia::where('products_id', $id)->get();

            $product = Product::findOrFail($id);
            
            if ($request->slug) {
                $product->slug = $request->slug;  
            } else {               
                $product->slug = StringHelper::createSlug($request->product_name, 'Product', 'slug', '-');                
            }

            // Retrieve the existing product           
            $product->fill([
                'product_name' => $request->product_name,
                'product_code' => $request->product_code,
                
                'category_id' => $request->parent_category_id,
                'product_price' => $request->product_price,
                'product_discounted_price' => $request->product_discounted_price ?? 0,
                'brand_id' => $request->brand_id ?? 0,
                'part_id' => $request->part_id ?? 0,
                'product_alt' => $request->product_alt ?? '',
                'products_description' => $request->products_description, 
                'products_specification' => $request->products_specification,
                'product_size_ids' => !empty($request->size_id) ? implode(",", $request->size_id) : null,
                'product_color_ids' => !empty($request->color_id) ? implode(",", $request->color_id) : null,
                'status' => $request->status ?? 1,
                'updated_at' => Carbon::now(),
            ]);
            $product->save();

            // Upload size chart image if provided
            if ($request->hasFile('product_sizechart_image')) {
                $product->product_sizechart_image = UploadHelper::upload(
                    'product_sizechart_image',
                    $request->file('product_sizechart_image'),
                    'product_sizechart-' . time(),
                    'assets/images/products'
                );
                $product->save();
            }


            for ($i = 1; $i <= $image_counter; $i++) {
                $input_name = 'product_images_' . $i;
                $existing_media_name = 'existing_media_' . $i;
                $delete_check_name = 'delete_check_' . $i;

            if(!isset($request->$delete_check_name)){

                if ($request->hasFile($input_name)) {
                    if ($request->$existing_media_name) {
                        $existingMedia = ProductMedia::find($request->$existing_media_name);
                        if ($existingMedia && $existingMedia->media) {
                            UploadHelper::delete('assets/images/products/' . $existingMedia->media);
                        }
                    }

                    // Upload the new media
                    $media = UploadHelper::upload(
                        $input_name, 
                        $request->file($input_name), 
                        'product_images-' . $i . '-' . time(), 
                        'assets/images/products' 
                    );

                    // Update or create the media record
                    ProductMedia::updateOrCreate(
                        [
                            'id' => $request->$existing_media_name, 
                        ],
                        [
                            'products_id' => $product->products_id,
                            'media_type' => 'photo',
                            //'product_code' => $product->product_code,
                            'media' => $media,
                            'is_default' => $i === 1 ? 'Y' : 'N', 
                            'updated_at' => Carbon::now(),
                        ]
                    );
                } elseif ($request->$existing_media_name) {
                    ProductMedia::updateOrCreate(
                        [
                            'id' => $request->$existing_media_name, 
                        ],
                        [
                            'products_id' => $product->products_id,
                            'media_type' => 'photo',
                            //'product_code' => $product->product_code,
                            'is_default' => $i === 1 ? 'Y' : 'N', 
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }else{

                 #########Delete Image here
                if (!is_null($request->$existing_media_name)) {  
                    $id = $request->$existing_media_name;
                    DB::table('wl_products_media')
                    ->where('id', $id)
                    ->update([
                        'media' => ''
                    ]);
                }
                #########################
            }
            }

            // Update product sizes
            if (is_array($request->size_id)) {
                DB::table('wl_product_sizes')->where('product_id', $product->products_id)->delete(); // Remove old sizes
                $sizes_data = array_map(function ($size_id) use ($product) {
                    return [
                        'size_id' => $size_id,
                        'product_id' => $product->products_id,
                    ];
                }, $request->size_id);
                DB::table('wl_product_sizes')->insert($sizes_data); // Insert new sizes
            }

            // Update product colors
            if (is_array($request->color_id)) {
                DB::table('wl_product_colors')->where('product_id', $product->products_id)->delete(); // Remove old colors
                $colors_data = array_map(function ($color_id) use ($product) {
                    return [
                        'color_id' => $color_id,
                        'product_id' => $product->products_id,
                    ];
                }, $request->color_id);
                DB::table('wl_product_colors')->insert($colors_data); // Insert new colors
            }

            // Insert or update product stock
            $productSizes = $request->size_id ?? [];
            $productColors = $request->color_id ?? [];

            if (!empty($productSizes) || !empty($productColors)) {
                $sizeString = implode(',', $productSizes);
                $colorString = implode(',', $productColors);

                // Delete existing stock entries not in the current selection
                DB::table('wl_product_stock')
                    ->where('product_id', $product->products_id)
                    ->where(function ($query) use ($sizeString, $colorString) {
                        $query->whereNotIn('product_size', explode(',', $sizeString))
                            ->orWhereNotIn('product_color', explode(',', $colorString));
                    })
                    ->delete();

                // Insert new stock entries
                foreach ($productSizes as $size) {
                    foreach ($productColors as $color) {
                        DB::table('wl_product_stock')->updateOrInsert(
                            [
                                'product_id' => $product->products_id,
                                'product_size' => $size,
                                'product_color' => $color,
                            ],
                            ['product_quantity' => 0]
                        );
                    }
                }
            } else {
                // Insert default stock entry if no sizes or colors are selected
                DB::table('wl_product_stock')->updateOrInsert(
                    [
                        'product_id' => $product->products_id,
                        'product_size' => 0,
                        'product_color' => 0,
                    ],
                    ['product_quantity' => 0]
                );
            }

            // Log the action
            Track::newTrack($product->product_name, 'Product has been updated');

            // Commit the transaction
            DB::commit();

            session()->flash('success', 'Product has been updated successfully!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            session()->flash('sticky_error', $e->getMessage());
            return back();
        }


    }


  
    




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('product.delete')) {
            $message = 'You are not allowed to access this page!';
            return view('errors.403', compact('message'));
        }

        // Find the product by its primary key
        $product = Product::find($id);

        // Debugging: Check if the product is found
        if (is_null($product)) {
            session()->flash('error', "The product is not found!");
            return redirect()->route('admin.products.trashed');
        }

        // Soft delete the product
        $product->deleted_at = Carbon::now();
       // $product->deleted_by = Auth::id();
        $product->status = 0;
        $product->save();

        session()->flash('success', 'Product has been deleted successfully as trashed!');
        return redirect()->route('admin.products.trashed');
    }
    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('category.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $product = Product::find($id);
        if (is_null($product)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.products.trashed');
        }
        $product->deleted_at = null;
        //$product->deleted_by = null;
        $product->save();

        session()->flash('success', 'Product has been revert back successfully !!');
        return redirect()->route('admin.products.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('product.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $product = Product::find($id);
        if (is_null($product)) {
            session()->flash('error', "The product is not found !");
            return redirect()->route('admin.products.trashed');
        }
        // Remove Images
        UploadHelper::deleteFile('public/assets/images/products/' . $product->media);
        // Delete Product permanently
        $product->delete();

        // Delete Product Images permanently
        $product_media = ProductMedia::where('products_id', $id);        
        if (is_null($product_media)) {
            session()->flash('error', "The media is not found !");
            return redirect()->route('admin.products.trashed');
        }       
        $product_media->delete();

        // Delete Product Color permanently
        $product_color = ProductColor::where('product_id', $id);   
        if (is_null($product_color)) {
            session()->flash('error', "The color is not found !");
            return redirect()->route('admin.products.trashed');
        }       
        $product_color->delete();
        
         // Delete Product Size permanently
        $product_size = ProductSize::where('product_id', $id);   
        if (is_null($product_size)) {
            session()->flash('error', "The size is not found !");
            return redirect()->route('admin.products.trashed');
        }       
        $product_size->delete();
        
        session()->flash('success', 'Product has been deleted permanently !!');
        return redirect()->route('admin.products.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('category.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }


    public function uploadMedia(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            // Save the file to the public storage directory
            $path = storage_path('app/public/uploads');
            $request->file('upload')->move($path, $fileName);

            // Generate the URL to the uploaded file
            $url = asset('storage/app/public/uploads/' . $fileName);

            // Return the response to CKEditor
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
        return false;
    }



    public function get_variants(Request $request, $id)
    {        
        // Fetch product stock data with size and color relationships
        $stocks = ProductStock::where('product_id', $id)
        ->join('wl_sizes', 'wl_product_stock.product_size', '=', 'wl_sizes.size_id')
        ->join('wl_colors', 'wl_product_stock.product_color', '=', 'wl_colors.color_id')
        ->select(
            'wl_product_stock.*', // Select all columns from product_stock
            'wl_sizes.size_name as size_name', // Select size name
            'wl_colors.color_name as color_name' // Select color name
        )
        ->get();
        // Return JSON response           
        return response()->json(['variants' => $stocks]);
    }

    public function updateStock(Request $request, $product_id)
    {
        // Fetch product stock data
        $res_array = ProductStock::where('product_id', $product_id)->get();
        
        // If the form is submitted via AJAX (i.e., no token is sent for standard POST)
        if ($request->ajax()) {
            $post_value = $request->all();
            
            // Loop through the posted values
            foreach ($post_value as $key => $val) {
                if (substr($key, 0, 4) == "qty_") {
                    $key1 = substr($key, 4); // Extract stock_id from the key
                    $invt = 'inv_' . $key1;
                    $val1 = $post_value[$invt]; // Inventory value
    
                    $pp = 'pp_' . $key1;
                    $val2 = $post_value[$pp]; // Product price
    
                    $dp = 'dp_' . $key1;
                    $val3 = $post_value[$dp]; // Discounted price
    
                    // Calculate discount percentage
                    $product_discount_percent = round(($val2 - $val3) / $val2 * 100);
    
                    // Update product stock
                    ProductStock::where('stock_id', $key1)->update([
                        'product_quantity' => $val,
                        'inventory' => $val1,
                        'product_price' => $val2,
                        'product_discounted_price' => $val3,
                        'product_discount_percent' => $product_discount_percent,
                    ]);
                }
            }
    
            // Update product's main price and discounted price
            $res = ProductStock::where('product_id', $product_id)
                ->orderBy('product_price', 'asc')
                ->first();
    
            if ($res) {
                Product::where('products_id', $product_id)->update([
                    'product_price' => $res->product_price,
                    'product_discounted_price' => $res->product_discounted_price,
                    'product_discount_percent' => $product_discount_percent,
                ]);
            }
    
            // Return success or error response as JSON
            session()->flash('success', 'Stock and price updated successfully!');
            return response()->json([
                'success' => true
            ]);
        }
    
       
    }

}

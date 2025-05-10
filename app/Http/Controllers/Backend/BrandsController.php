<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class BrandsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('brand.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $brands = Brand::orderBy('brand_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $brands = Brand::orderBy('brand_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($brands, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->brand_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Brand Details" href="' . route('admin.brands.show', $row->brand_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.brands.destroy', [$row->brand_id]);
                            if ($this->user->can('brand.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Brand Details" href="' . route('admin.brands.edit', $row->brand_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('brand.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->brand_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('brand.delete')) {
                                $deleteRoute =  route('admin.brands.trashed.destroy', [$row->brand_id]);
                                $revertRoute = route('admin.brands.trashed.revert', [$row->brand_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->brand_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->brand_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Brand Permanently" id="deleteItemPermanent' . $row->brand_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('brand.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->brand_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Brand will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->brand_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->brand_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Brand will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->brand_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->brand_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Brand will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->brand_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->brand_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->brand_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('brand_name', function ($row) {
                    return $row->brand_name;
                })
                ->editColumn('brand_image', function ($row) {
                    if ($row->brand_image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/brands/' . $row->brand_image) . "' class='img img-display-list img-source' onclick='full_view(this);' />
                        </div>
                        ";
                    }
                    return '-';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success font-weight-100">Active</span>';
                    } else if ($row->deleted_at != null) {
                        return '<span class="badge badge-danger">Trashed</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                });
            $rawColumns = ['checkbox', 'action', 'brand_name', 'status', 'brand_image'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_brands = count(Brand::select('brand_id')->get());
        $count_active_brands = count(Brand::select('brand_id')->where('status', 1)->get());
        $count_trashed_brands = count(Brand::select('brand_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.brands.index', compact('count_brands', 'count_active_brands', 'count_trashed_brands'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Brand::whereIn('brand_id', $ids)->delete();
           // session()->flash('success', 'New Brand has been deleted successfully !!');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('brand.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if (is_null($this->user) || !$this->user->can('brand.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'brand_name'  => 'required|max:100',
            'slug'  => 'nullable|max:100|unique:wl_brands,slug',
            'brand_image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $brand = new Brand();
            $brand->brand_name = $request->brand_name;

            if ($request->slug) {
                $brand->slug = StringHelper::createSlug($request->slug, 'Brand', 'slug', '-');  
            } else {               
                $brand->slug = StringHelper::createSlug($request->brand_name, 'Brand', 'slug', '-');                
            }

            if (!is_null($request->brand_image)) {
                $brand->brand_image = UploadHelper::upload('image', $request->brand_image, Str::slug($request->brand_name) . '-' . time() . '-logo', 'assets/images/brands');
            }

            $brand->status = $request->status;           
            $brand->created_at = Carbon::now();
            $brand->updated_at = Carbon::now();
            $brand->save();

            Track::newTrack($brand->brand_name, 'New Brand has been created');
            DB::commit();
            session()->flash('success', 'New Brand has been created successfully !!');
            return redirect()->route('admin.brands.index');
        } catch (\Exception $e) {
            session()->flash('sticky_error', $e->getMessage());
            DB::rollBack();
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
        if (is_null($this->user) || !$this->user->can('brand.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $brand = Brand::find($id);
        return view('backend.pages.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('brand.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $brand = Brand::find($id);
        return view('backend.pages.brands.edit', compact('brand'));
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
        if (is_null($this->user) || !$this->user->can('brand.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $brand = Brand::find($id);
        if (is_null($brand)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.brands.index');
        }

        $request->validate([
            'brand_name'  => 'required|max:100',
            'slug'  => 'required|max:100|unique:wl_brands,slug,' . $brand->brand_id.',brand_id',
            'brand_image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $brand->brand_name = $request->brand_name;
            $brand->status = $request->status;

            if ($request->slug) {
                $brand->slug = StringHelper::createSlug($request->slug, 'Brand', 'slug', '-');  
            } else {               
                $brand->slug = StringHelper::createSlug($request->brand_name, 'Brand', 'slug', '-');                
            }

            if (!is_null($request->brand_image)) {
                $brand->brand_image = UploadHelper::update('image', $request->brand_image, Str::slug($request->brand_name) . '-' . time() . '-logo', 'assets/images/brands', $brand->brand_image);
            }

            $brand->status = $request->status; 
            $brand->updated_at = Carbon::now();
            $brand->save();

            Track::newTrack($brand->brand_name, 'Brand has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Brand has been updated successfully !!');
            return redirect()->route('admin.brands.index');
        } catch (\Exception $e) {
            session()->flash('sticky_error', $e->getMessage());
            DB::rollBack();
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
        if (is_null($this->user) || !$this->user->can('brand.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $brand = Brand::find($id);
        if (is_null($brand)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.brands.trashed');
        }
        $brand->deleted_at = Carbon::now();
        $brand->status = 0;
        $brand->save();

        session()->flash('success', 'Brand has been deleted successfully as trashed !!');
        return redirect()->route('admin.brands.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('brand.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $brand = Brand::find($id);
        if (is_null($brand)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.brands.trashed');
        }
        $brand->deleted_at = null;
        $brand->save();

        session()->flash('success', 'Brand has been revert back successfully !!');
        return redirect()->route('admin.brands.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('brand.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $brand = Brand::find($id);
        if (is_null($brand)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.brands.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('public/assets/images/brands/' . $brand->image);

        // Delete Brand permanently
        $brand->delete();

        session()->flash('success', 'Brand has been deleted permanently !!');
        return redirect()->route('admin.brands.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('brand.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

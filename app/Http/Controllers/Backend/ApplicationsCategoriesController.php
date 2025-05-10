<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\ApplicationsCategories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ApplicationsCategoriesController extends Controller
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
       
        if ( is_null($this->user) || ! $this->user->can('applicationsCategories.view') ) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $applicationsCategories = applicationsCategories::orderBy('id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $applicationsCategories = applicationsCategories::orderBy('id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($applicationsCategories, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = "";

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.applicationsCategories.destroy', [$row->id]);
                            if( $this->user->can('applicationsCategories.edit')) {
                                $html = '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle" title="Edit Category Details" href="' . route('admin.applicationsCategories.edit', $row->id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if( $this->user->can('applicationsCategories.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-2 text-white" title="Delete Admin" id="deleteItem' . $row->id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } elseif($this->user->can('applicationsCategories.delete')) {
                            $deleteRoute =  route('admin.applicationsCategories.trashed.destroy', [$row->id]);
                            $revertRoute = route('admin.applicationsCategories.trashed.revert', [$row->id]);

                            $html = '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle" title="Revert Back" id="revertItem' . $row->id . '"><i class="fa fa-check"></i></a>';
                            $html .= '
                            <form id="revertForm' . $row->id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Revert</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                            $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-2 text-white" title="Delete Category Permanently" id="deleteItemPermanent' . $row->id . '"><i class="fa fa-trash"></i></a>';
                        }



                        $html .= '<script>
                            $("#deleteItem' . $row->id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Category will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->id . '").submit();}})
                            });
                        </script>';

                        $html .= '<script>
                            $("#deleteItemPermanent' . $row->id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Category will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->id . '").submit();}})
                            });
                        </script>';

                        $html .= '<script>
                            $("#revertItem' . $row->id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Category will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->id . '").submit();}})
                            });
                        </script>';

                        $html .= '
                            <form id="deleteForm' . $row->id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                        $html .= '
                            <form id="deletePermanentForm' . $row->id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        return $html;
                    }
                )

                ->editColumn('name', function ($row) {
                    return $row->name;
                    // . ' <br /><a href="' . route('applicationsCategories.show', $row->slug) . '" target="_blank"><i class="fa fa-link"></i> View</a>';
                })
                /*->editColumn('banner_image', function ($row) {
                    if ($row->banner_image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/applicationsCategories/' . $row->banner_image) . "' class='img img-display-list img-source' />

                            <img src='" . asset('assets/backend/images/expand.png') . "' class='expand-icon' onclick='full_view(this);' class='img img-display-list img-source' />

                        </div>
                        ";
                    }
                    return '-';
                })
                */
                ->editColumn('category_image', function ($row) {
                    if ($row->category_image != null) {
                        
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/application_categories/' . $row->category_image) . "' class='img img-display-list img-source' style='width:100px;' onclick='full_view(this);'/>
                        </div>
                        ";
                    }
                    return '-';
                })
                ->addColumn('parent_category', function ($row) {
                    $html = "";
                    $parent = applicationsCategories::find($row->parent_category_id);
                    if (!is_null($parent)) {
                        $html .= $parent->name;
                    } else {
                        $html .= "-";
                    }
                    return $html;
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
            $rawColumns = ['checkbox','action', 'name', 'status', 'parent_categories', 'category_image', 'priority'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_applicationsCategories = count(applicationsCategories::select('id')->get());
        $count_active_applicationsCategories = count(applicationsCategories::select('id')->where('status', 1)->get());
        $count_trashed_applicationsCategories = count(applicationsCategories::select('id')->where('deleted_at', '!=', null)->get());

        
        return view('backend.applicationsCategories.index', compact('count_applicationsCategories', 'count_active_applicationsCategories', 'count_trashed_applicationsCategories'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            applicationsCategories::whereIn('id', $ids)->delete();
           // session()->flash('success', 'New Blog has been deleted successfully !!');
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
        $categories = applicationsCategories::printCategory(null, $layer = 2);
        return view('backend.applicationsCategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('applicationsCategories.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'name'  => 'required|max:100|unique:wl_applications_categories,name',
            'slug'  => 'nullable|max:100|unique:wl_applications_categories,slug',
            'category_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
            //'banner_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $applicationsCategories = new applicationsCategories();
            $applicationsCategories->name = $request->name;
           
           /* if ($request->slug) {
                $applicationsCategories->slug = $request->slug;
            } else {
                $applicationsCategories->slug = StringHelper::createSlug($request->name, 'App\Models\Category', 'slug', '-', true);
            }
            */

            if ($request->slug) {
                $applicationsCategories->slug = $request->slug;  
            } else {               
                $applicationsCategories->slug = StringHelper::createSlug($request->name, 'Category', 'slug', '-');                
            }

            /*if (!is_null($request->banner_image)) {
                $applicationsCategories->banner_image = UploadHelper::upload('banner_image', $request->banner_image, $request->name . '-' . time() . '-banner', 'assets/images/applicationsCategories');
            }
            */

            if (!is_null($request->category_image)) {
                $applicationsCategories->category_image = UploadHelper::upload('category_image', $request->category_image, Str::slug($request->name) . '-' . time()  . '-logo', 'assets/images/application_categories');
            }

            $applicationsCategories->parent_category_id = $request->parent_category_id;
            $applicationsCategories->status = $request->status;
            if (!is_null($request->enable_bg)) {
                $applicationsCategories->enable_bg = 1;
                $applicationsCategories->bg_color = $request->bg_color;
                $applicationsCategories->text_color = $request->text_color;
            }

            $applicationsCategories->description = $request->description;
            $applicationsCategories->meta_description = $request->meta_description;
            $applicationsCategories->priority = $request->priority ? $request->priority : 1;
            $applicationsCategories->created_at = Carbon::now();
            $applicationsCategories->created_by = Auth::id();
            $applicationsCategories->updated_at = Carbon::now();

           
            $applicationsCategories->save();

            // Update priority column
            if(!$request->priority){
                $applicationsCategories->priority = $applicationsCategories->id;
                if($request->parent_category_id){
                    $lastCategoryPriorityValue = applicationsCategories::where('parent_category_id', $request->parent_category_id)
                    ->orderBy('priority', 'desc')
                    ->value('priority');
                    if(!is_null($lastCategoryPriorityValue)){
                        $applicationsCategories->priority = (int) $lastCategoryPriorityValue + 1;
                    }
                }
                $applicationsCategories->save();
            }

            $data = [
                'applicationsCategories' => $applicationsCategories->id,
                'en' => $applicationsCategories->name,
                'key' => $applicationsCategories->slug
            ];

            Track::newTrack($applicationsCategories->name, 'New Category has been created');
            DB::commit();
            session()->flash('success', 'New Category has been created successfully !!');
            return redirect()->route('admin.applicationsCategories.index');
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
        if (is_null($this->user) || !$this->user->can('applicationsCategories.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $applicationsCategories   = applicationsCategories::find($id);            
        $categories = applicationsCategories::printCategory($applicationsCategories->parent_category_id, $layer = 2);

        return view('backend.applicationsCategories.edit', compact('applicationsCategories', 'categories'));
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
        if (is_null($this->user) || !$this->user->can('applicationsCategories.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $applicationsCategories = applicationsCategories::find($id);
        if (is_null($applicationsCategories)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.applicationsCategories.index');
        }

        $request->validate([
            'name'  => 'required|max:100',
            'slug'  => 'required|max:100|unique:wl_applications_categories,slug,' . $applicationsCategories->id,
            'categories_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
           // 'banner_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $applicationsCategories->name = $request->name;            
            $applicationsCategories->status = $request->status;

            if ($request->slug) {
                $applicationsCategories->slug = $request->slug;  
            } else {               
                $applicationsCategories->slug = StringHelper::createSlug($request->name, 'Category', 'slug', '-');                
            }

            /*if (!is_null($request->banner_image)) {
                $applicationsCategories->banner_image = UploadHelper::update('banner_image', $request->banner_image, $request->name . '-' . time() . '-banner', 'assets/images/applicationsCategories', $applicationsCategories->banner_image);
            }
            */

            if (!is_null($request->category_image)) {
                $applicationsCategories->category_image = UploadHelper::update('category_image', $request->category_image, $request->slug . '-' . time() . '-logo', 'assets/images/application_categories', $applicationsCategories->category_image);
            }

            $applicationsCategories->parent_category_id = $request->parent_category_id;
            $applicationsCategories->status = $request->status;
            if (!is_null($request->enable_bg)) {
                $applicationsCategories->enable_bg = 1;
                $applicationsCategories->bg_color = $request->bg_color;
                $applicationsCategories->text_color = $request->text_color;
            } else {
                $applicationsCategories->enable_bg = 0;
            }
            $applicationsCategories->description = $request->description;
            $applicationsCategories->meta_description = $request->meta_description;
            $applicationsCategories->priority = $request->priority;
            $applicationsCategories->updated_by = Auth::id();
            $applicationsCategories->updated_at = Carbon::now();
            $applicationsCategories->save();

            // Update priority column
            if(!$request->priority){
                $applicationsCategories->priority = $applicationsCategories->id;
                if($request->parent_categorie_id){
                    $lastCategoryPriorityValue = applicationsCategories::where('parent_category_id', $request->parent_categorie_id)
                    ->orderBy('priority', 'desc')
                    ->value('priority');
                    if(!is_null($lastCategoryPriorityValue)){
                        $applicationsCategories->priority = (int) $lastCategoryPriorityValue + 1;
                    }
                }
                $applicationsCategories->save();
            }

            $data = [
                'categories' => $applicationsCategories->id,
                'en' => $applicationsCategories->name,
                'key' => $applicationsCategories->slug
            ];

            Track::newTrack($applicationsCategories->slug, 'Category has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Category has been updated successfully !!');
            return redirect()->route('admin.applicationsCategories.index');
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
        if (is_null($this->user) || !$this->user->can('applicationsCategories.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $applicationsCategories = applicationsCategories::find($id);
        if (is_null($applicationsCategories)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.applicationsCategories.trashed');
        }
        $applicationsCategories->deleted_at = Carbon::now();
        $applicationsCategories->deleted_by = Auth::id();
        $applicationsCategories->status = 0;
        $applicationsCategories->save();

        session()->flash('success', 'Category has been deleted successfully as trashed !!');
        return redirect()->route('admin.applicationsCategories.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('applicationsCategories.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $applicationsCategories = applicationsCategories::find($id);
        if (is_null($applicationsCategories)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.applicationsCategories.trashed');
        }
        $applicationsCategories->deleted_at = null;
        $applicationsCategories->deleted_by = null;
        $applicationsCategories->save();

        session()->flash('success', 'Category has been revert back successfully !!');
        return redirect()->route('admin.applicationsCategories.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('applicationsCategories.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $applicationsCategories = applicationsCategories::find($id);
        if (is_null($applicationsCategories)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.applicationsCategories.trashed');
        }

        // Remove Images
        UploadHelper::deleteFile('assets/images/applicationsCategoriess/' . $applicationsCategories->banner_image);
        UploadHelper::deleteFile('assets/images/applicationsCategoriess/' . $applicationsCategories->image);

        // Delete Category permanently
        $applicationsCategories->delete();

        session()->flash('success', 'Category has been deleted permanently !!');
        return redirect()->route('admin.applicationsCategories.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('applicationsCategories.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

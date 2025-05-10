<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class BannersController extends Controller
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
        if (is_null($this->user) || !$this->user->can('banners.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $banners = Banner::orderBy('banner_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $banners = Banner::orderBy('banner_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($banners, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->banner_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Banner Details" href="' . route('admin.banners.show', $row->banner_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.banners.destroy', [$row->banner_id]);
                            if ($this->user->can('banners.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Banner Details" href="' . route('admin.banners.edit', $row->banner_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('banners.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->banner_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('banners.delete')) {
                                $deleteRoute =  route('admin.banners.trashed.destroy', [$row->banner_id]);
                                $revertRoute = route('admin.banners.trashed.revert', [$row->banner_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->banner_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->banner_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Banner Permanently" id="deleteItemPermanent' . $row->banner_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('banners.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->banner_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Banner will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->banner_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->banner_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Banner will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->banner_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->banner_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Banner will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->banner_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->banner_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->banner_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('banner_position', function ($row) {
                    return $row->banner_position;
                })
                ->editColumn('banner_image', function ($row) {
                    if ($row->banner_image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/banners/' . $row->banner_image) . "' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'banner_position', 'status', 'banner_image'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_banners = count(Banner::select('banner_id')->get());
        $count_active_banners = count(Banner::select('banner_id')->where('status', 1)->get());
        $count_trashed_banners = count(Banner::select('banner_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.banners.index', compact('count_banners', 'count_active_banners', 'count_trashed_banners'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Banner::whereIn('banner_id', $ids)->delete();
           // session()->flash('success', 'New Banner has been deleted successfully !!');
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
        if (is_null($this->user) || !$this->user->can('banners.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if (is_null($this->user) || !$this->user->can('banners.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }
    
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
    
        try {
            DB::beginTransaction();
            
            // Ensure directory exists
            $targetDir = public_path('assets/images/banners');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
    
            $banner = new Banner();
            $banner->banner_position = 'Inner Pages Top';
    
            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $filename = time() . '-BANNER.' . $image->getClientOriginalExtension();
                
                // Store the file
                $path = $image->move($targetDir, $filename);
                
                // Save path relative to public folder
                $banner->banner_image = $filename;
            }
            
            $banner->status = $request->status;           
            $banner->created_at = Carbon::now();
            $banner->updated_at = Carbon::now();
            $banner->save();
            
            DB::commit();
            session()->flash('success', 'New Banner has been created successfully !!');
            return redirect()->route('admin.banners.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('sticky_error', 'Upload failed: ' . $e->getMessage());
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
        if (is_null($this->user) || !$this->user->can('banners.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $banner = Banner::find($id);
        return view('backend.pages.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('banners.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $banner = Banner::find($id);
        return view('backend.pages.banners.edit', compact('banner'));
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
        if (is_null($this->user) || !$this->user->can('banners.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $banner = Banner::find($id);
        if (is_null($banner)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.banners.index');
        }

        $request->validate([
            'banner_image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $banner->status = $request->status;

            //$filename = time() . '-BANNER.' . $image->getClientOriginalExtension();

            if (!is_null($request->banner_image)) {
                $banner->banner_image = UploadHelper::update('image', $request->banner_image, time() . '-BANNER', 'assets/images/banners', $banner->banner_image);
            }

            $banner->status = $request->status; 
            $banner->updated_at = Carbon::now();
            $banner->save();

            DB::commit();
            session()->flash('success', 'Banner has been updated successfully !!');
            return redirect()->route('admin.banners.index');
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
        if (is_null($this->user) || !$this->user->can('banners.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $banner = Banner::find($id);
        if (is_null($banner)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.banners.trashed');
        }
        $banner->deleted_at = Carbon::now();
        $banner->status = 0;
        $banner->save();

        session()->flash('success', 'Banner has been deleted successfully as trashed !!');
        return redirect()->route('admin.banners.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('banners.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $banner = Banner::find($id);
        if (is_null($banner)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.banners.trashed');
        }
        $banner->deleted_at = null;
        $banner->save();

        session()->flash('success', 'Banner has been revert back successfully !!');
        return redirect()->route('admin.banners.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('banners.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $banner = Banner::find($id);
        if (is_null($banner)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.banners.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('assets/images/banners/' . $banner->image);

        // Delete Banner permanently
        $banner->delete();

        session()->flash('success', 'Banner has been deleted permanently !!');
        return redirect()->route('admin.banners.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('banners.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

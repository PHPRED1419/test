<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\VideoAlbum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class VideoAlbumController extends Controller
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
        if (is_null($this->user) || !$this->user->can('videoAlbum.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $categories = VideoAlbum::orderBy('category_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $categories = VideoAlbum::orderBy('category_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();            
            }

            $datatable = DataTables::of($categories, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->category_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View BlogsCategories Details" href="' . route('admin.video_album.show', $row->category_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.video_album.destroy', [$row->category_id]);
                            if ($this->user->can('videoAlbum.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit BlogsCategories Details" href="' . route('admin.video_album.edit', $row->category_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('videoAlbum.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->category_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('videoAlbum.delete')) {
                                $deleteRoute =  route('admin.video_album.trashed.destroy', [$row->category_id]);
                                $revertRoute = route('admin.video_album.trashed.revert', [$row->category_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->category_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->category_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete BlogsCategories Permanently" id="deleteItemPermanent' . $row->category_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('videoAlbum.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->category_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "BlogsCategories will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->category_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->category_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "BlogsCategories will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->category_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->category_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "BlogsCategories will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->category_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->category_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->category_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('category_name', function ($row) {
                    return $row->category_name;
                })
                ->editColumn('category_image', function ($row) {
                    if ($row->category_image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/video_album/' . $row->category_image) . "' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'category_name', 'status', 'category_image'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_album = count(VideoAlbum::select('category_id')->get());
        $count_active = count(VideoAlbum::select('category_id')->where('status', 1)->get());
        $count_trashed_album = count(VideoAlbum::select('category_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.video_album.index', compact('count_album', 'count_active', 'count_trashed_album'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            VideoAlbum::whereIn('category_id', $ids)->delete();
           // session()->flash('success', 'New BlogsCategories has been deleted successfully !!');
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
        if (is_null($this->user) || !$this->user->can('videoAlbum.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }
        
        return view('backend.pages.video_album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if (is_null($this->user) || !$this->user->can('videoAlbum.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'category_name'  => 'required|max:100',
            'slug'  => 'nullable|max:100|unique:wl_video_album,slug',
            'category_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $category = new VideoAlbum();
            $category->category_name = $request->category_name;

            if ($request->slug) {
                $category->slug = StringHelper::createSlug($request->slug, 'VideoAlbum', 'slug', '-');  
            } else {               
                $category->slug = StringHelper::createSlug($request->category_name, 'VideoAlbum', 'slug', '-');                
            }
           
            if (!is_null($request->category_image)) {
                $category->category_image = UploadHelper::upload('category_image', $request->category_image, Str::slug($request->category_name) . '-' . time() . '-VIDIMG', 'assets/images/video_album');
            }

            $category->status = $request->status;           
            $category->created_at = Carbon::now();
            $category->updated_at = Carbon::now();
            $category->save();

            Track::newTrack($category->category_name, 'New Album has been created');
            DB::commit();
            session()->flash('success', 'New Album has been created successfully !!');
            return redirect()->route('admin.video_album.index');
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
        if (is_null($this->user) || !$this->user->can('videoAlbum.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $category = VideoAlbum::find($id);
        return view('backend.pages.video_album.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('videoAlbum.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $category = VideoAlbum::find($id);
        return view('backend.pages.video_album.edit', compact('category'));
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
        if (is_null($this->user) || !$this->user->can('videoAlbum.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $category = VideoAlbum::find($id);
        if (is_null($category)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.blogs_categories.index');
        }

        $request->validate([
            'category_name'  => 'required|max:100',
            'slug'  => 'required|max:100|unique:wl_video_album,slug,' . $category->category_id.',category_id',
            'category_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $category->category_name = $request->category_name;
            $category->status = $request->status;

            if ($request->slug) {
                $category->slug = $request->slug;  
            } else {               
                $category->slug = StringHelper::createSlug($request->category_name, 'VideoAlbum', 'slug', '-');                
            }

            #########Delete Image here
            if (!is_null($request->delete_check)) {  
                $oldImagePath = $category->category_image;
                $category->category_image = null;
                $request->category_image = null;                
                if ($oldImagePath) {
                    $fullPath = public_path('assets/images/video_album/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
            #########################

            if (!is_null($request->category_image)) {
                $category->category_image = UploadHelper::upload('category_image', $request->category_image, Str::slug($request->category_name) . '-' . time() . '-VIDIMG', 'assets/images/video_album');
            }
            
            $category->status = $request->status; 
            $category->updated_at = Carbon::now();
            $category->save();

            Track::newTrack($category->category_name, 'Album has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Album has been updated successfully !!');
            return redirect()->route('admin.video_album.index');
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
        if (is_null($this->user) || !$this->user->can('videoAlbum.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $category = VideoAlbum::find($id);
        if (is_null($category)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.video_album.trashed');
        }
        $category->deleted_at = Carbon::now();
        $category->status = 0;
        $category->save();

        session()->flash('success', 'Album has been deleted successfully as trashed !!');
        return redirect()->route('admin.video_album.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('videoAlbum.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $category = VideoAlbum::find($id);
        if (is_null($brand)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.video_album.trashed');
        }
        $category->deleted_at = null;
        $category->save();

        session()->flash('success', 'Album has been revert back successfully !!');
        return redirect()->route('admin.video_album.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('videoAlbum.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $category = VideoAlbum::find($id);
        if (is_null($category)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.video_album.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('assets/images/video_album/' . $category->image);

        // Delete BlogsCategories permanently
        $category->delete();

        session()->flash('success', 'Album has been deleted permanently !!');
        return redirect()->route('admin.video_album.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('videoAlbum.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

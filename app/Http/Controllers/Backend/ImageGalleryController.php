<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\ImageGallery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class ImageGalleryController extends Controller
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
        if (is_null($this->user) || !$this->user->can('ImageGallery.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $categories = ImageGallery::orderBy('gallery_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $categories = ImageGallery::orderBy('gallery_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();            
            }

            $datatable = DataTables::of($categories, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->gallery_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View BlogsCategories Details" href="' . route('admin.image_gallery.show', $row->gallery_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.image_gallery.destroy', [$row->gallery_id]);
                            if ($this->user->can('ImageGallery.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit BlogsCategories Details" href="' . route('admin.image_gallery.edit', $row->gallery_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('ImageGallery.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->gallery_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('ImageGallery.delete')) {
                                $deleteRoute =  route('admin.image_gallery.trashed.destroy', [$row->gallery_id]);
                                $revertRoute = route('admin.image_gallery.trashed.revert', [$row->gallery_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->gallery_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->gallery_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete BlogsCategories Permanently" id="deleteItemPermanent' . $row->gallery_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('ImageGallery.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->gallery_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "BlogsCategories will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->gallery_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->gallery_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "BlogsCategories will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->gallery_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->gallery_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "BlogsCategories will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->gallery_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->gallery_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->gallery_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('title', function ($row) {
                    return $row->title;
                })
                ->editColumn('photo', function ($row) {
                    if ($row->photo != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/image_gallery/' . $row->photo) . "' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'title', 'status', 'photo'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_photo = count(ImageGallery::select('gallery_id')->get());
        $count_active_photo = count(ImageGallery::select('gallery_id')->where('status', 1)->get());
        $count_trashed_photo = count(ImageGallery::select('gallery_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.image_gallery.index', compact('count_photo', 'count_active_photo', 'count_trashed_photo'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            ImageGallery::whereIn('gallery_id', $ids)->delete();
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
        if (is_null($this->user) || !$this->user->can('ImageGallery.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }
        $categories = DB::table('wl_media_album')
        ->orderBy('category_name', 'asc')
        ->get();
        return view('backend.pages.image_gallery.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if (is_null($this->user) || !$this->user->can('ImageGallery.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'title'  => 'required|max:100|unique:wl_media_gallery,title',
            'category_id'  => 'required|max:100',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $gallery = new ImageGallery();
            $gallery->title = $request->title;
            $gallery->category_id = $request->category_id;
           
            if (!is_null($request->photo)) {
                $gallery->photo = UploadHelper::upload('photo', $request->photo, Str::slug($request->title) . '-' . time() . '-PHIMG', 'assets/images/image_gallery');
            }

            $gallery->status = $request->status;           
            $gallery->created_at = Carbon::now();
            $gallery->updated_at = Carbon::now();
            $gallery->save();

            Track::newTrack($gallery->title, 'New Gallery has been created');
            DB::commit();
            session()->flash('success', 'New Gallery has been created successfully !!');
            return redirect()->route('admin.image_gallery.index');
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
        if (is_null($this->user) || !$this->user->can('ImageGallery.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $gallery = ImageGallery::find($id);
        return view('backend.pages.image_gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('ImageGallery.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $gallery = ImageGallery::find($id);
        $categories = DB::table('wl_media_album')
        ->orderBy('category_name', 'asc')
        ->get();
        return view('backend.pages.image_gallery.edit', compact('gallery','categories'));
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
        if (is_null($this->user) || !$this->user->can('ImageGallery.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $gallery = ImageGallery::find($id);
        if (is_null($gallery)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.image_gallery.index');
        }

        $request->validate([
            'title'  => 'required|max:100|unique:wl_media_gallery,title,' . $gallery->gallery_id.',gallery_id',
            'category_id'  => 'required|max:100',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $gallery->title = $request->title;
            $gallery->status = $request->status;
            $gallery->category_id = $request->category_id;

            #########Delete Image here
            if (!is_null($request->delete_check)) {  
                $oldImagePath = $gallery->photo;
                $gallery->photo = null;
                $request->photo = null;                
                if ($oldImagePath) {
                    $fullPath = public_path('assets/images/image_gallery/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
            #########################

            if (!is_null($request->photo)) {
                $gallery->photo = UploadHelper::upload('photo', $request->photo, Str::slug($request->title) . '-' . time() . '-PHIMG', 'assets/images/image_gallery');
            }
            
            $gallery->status = $request->status; 
            $gallery->updated_at = Carbon::now();
            $gallery->save();

            Track::newTrack($gallery->title, 'Gallery has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Gallery has been updated successfully !!');
            return redirect()->route('admin.image_gallery.index');
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
        if (is_null($this->user) || !$this->user->can('ImageGallery.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $gallery = ImageGallery::find($id);
        if (is_null($gallery)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.image_gallery.trashed');
        }
        $gallery->deleted_at = Carbon::now();
        $gallery->status = 0;
        $gallery->save();

        session()->flash('success', 'Album has been deleted successfully as trashed !!');
        return redirect()->route('admin.image_gallery.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('ImageGallery.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $gallery = ImageGallery::find($id);
        if (is_null($brand)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.image_gallery.trashed');
        }
        $gallery->deleted_at = null;
        $gallery->save();

        session()->flash('success', 'Album has been revert back successfully !!');
        return redirect()->route('admin.image_gallery.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('ImageGallery.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $gallery = ImageGallery::find($id);
        if (is_null($gallery)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.image_gallery.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('assets/images/image_gallery/' . $gallery->image);

        // Delete BlogsCategories permanently
        $gallery->delete();

        session()->flash('success', 'Album has been deleted permanently !!');
        return redirect()->route('admin.image_gallery.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('ImageGallery.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class BlogsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('blog.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $blogs = Blog::orderBy('id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $blogs = Blog::orderBy('id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($blogs, $isTrashed)
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
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Blog Details" href="' . route('admin.blogs.show', $row->id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.blogs.destroy', [$row->id]);
                            if ($this->user->can('blog.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Blog Details" href="' . route('admin.blogs.edit', $row->id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('blog.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('blog.delete')) {
                                $deleteRoute =  route('admin.blogs.trashed.destroy', [$row->id]);
                                $revertRoute = route('admin.blogs.trashed.revert', [$row->id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Blog Permanently" id="deleteItemPermanent' . $row->id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('blog.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Blog will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Blog will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Blog will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
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
                        }
                        return $html;
                    }
                )

                ->editColumn('title', function ($row) {
                    return $row->title;
                })
                ->editColumn('image', function ($row) {
                    if ($row->image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/blogs/' . $row->image) . "' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'title', 'status', 'image'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_blogs = count(Blog::select('id')->get());
        $count_active_blogs = count(Blog::select('id')->where('status', 1)->get());
        $count_trashed_blogs = count(Blog::select('id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.blogs.index', compact('count_blogs', 'count_active_blogs', 'count_trashed_blogs'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Blog::whereIn('id', $ids)->delete();
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
        if (is_null($this->user) || !$this->user->can('blog.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $categories = DB::table('wl_blog_categories')
        ->orderBy('category_name', 'asc')
        ->get();

        return view('backend.pages.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('blog.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'category_id'  => 'required|max:100',
            'title'  => 'required|max:100',
            'slug'  => 'nullable|max:100|unique:wl_blogs,slug',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image2'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image3'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image4'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $blog = new Blog();
            $blog->category_id = $request->category_id;   
            $blog->title = $request->title;           

            if ($request->slug) {
                $blog->slug = StringHelper::createSlug($request->slug, 'Blog', 'slug', '-');  
            } else {               
                $blog->slug = StringHelper::createSlug($request->title, 'Blog', 'slug', '-');                
            }

            if (!is_null($request->image)) {
                $blog->image = UploadHelper::upload('image', $request->image, Str::slug($request->title) . '-1' . time() . '-logo', 'assets/images/blogs');
            }

            if (!is_null($request->image2)) {
                $blog->image2 = UploadHelper::upload('image', $request->image2, Str::slug($request->title) . '-2' . time() . '-logo', 'assets/images/blogs');
            }

            if (!is_null($request->image3)) {
                $blog->image3 = UploadHelper::upload('image', $request->image3, Str::slug($request->title) . '-3' . time() . '-logo', 'assets/images/blogs');
            }

            if (!is_null($request->image4)) {
                $blog->image4 = UploadHelper::upload('image', $request->image4, Str::slug($request->title) . '-4' . time() . '-logo', 'assets/images/blogs');
            }

            $blog->status = $request->status;
            $blog->description = $request->description;
            $blog->meta_description = $request->meta_description;
            $blog->created_at = Carbon::now();
            $blog->created_by = Auth::id();
            $blog->updated_at = Carbon::now();
            $blog->save();

            Track::newTrack($blog->title, 'New Blog has been created');
            DB::commit();
            session()->flash('success', 'New Blog has been created successfully !!');
            return redirect()->route('admin.blogs.index');
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
        if (is_null($this->user) || !$this->user->can('blog.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $blog = Blog::find($id);
        return view('backend.pages.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('blog.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $blog = Blog::find($id);
        $categories = DB::table('wl_blog_categories')
        ->orderBy('category_name', 'asc')
        ->get();
        return view('backend.pages.blogs.edit', compact('blog','categories'));
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
        if (is_null($this->user) || !$this->user->can('blog.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $blog = Blog::find($id);
        if (is_null($blog)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.blogs.index');
        }

        $request->validate([
            'category_id'  => 'required|max:100',
            'title'  => 'required|max:100',
            'slug'  => 'required|max:100|unique:wl_blogs,slug,' . $blog->id,
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image2'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image3'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image4'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();
            $blog->category_id = $request->category_id;  
            $blog->title = $request->title;            
            $blog->status = $request->status;

            if ($request->slug) {
                $blog->slug = $request->slug;  
            } else {               
                $blog->slug = StringHelper::createSlug($request->title, 'Blog', 'slug', '-');                
            }

            #########Delete Image here
            if (!is_null($request->delete_check_1)) {  
                $oldImagePath = $blog->image;
                $blog->image = null;
                $request->image = null;                
                if ($oldImagePath) {
                    $fullPath = public_path('assets/images/blogs/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            if (!is_null($request->delete_check_2)) {  
                $oldImagePath = $blog->image2;
                $blog->image2 = null;
                $request->image2 = null;                
                if ($oldImagePath) {
                    $fullPath = public_path('assets/images/blogs/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            if (!is_null($request->delete_check_3)) {  
                $oldImagePath = $blog->image3;
                $blog->image3 = null;
                $request->image3 = null;                
                if ($oldImagePath) {
                    $fullPath = public_path('assets/images/blogs/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            if (!is_null($request->delete_check_4)) {  
                $oldImagePath = $blog->image4;
                $blog->image4 = null;
                $request->image4 = null;                
                if ($oldImagePath) {
                    $fullPath = public_path('assets/images/blogs/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
            #########################

            if (!is_null($request->image)) {
                $blog->image = UploadHelper::update('image', $request->image, Str::slug($request->title) . '-1' . time() . '-logo', 'assets/images/blogs', $blog->image);
            }

            if (!is_null($request->image2)) {
                $blog->image2 = UploadHelper::update('image', $request->image2, Str::slug($request->title) . '-2' . time() . '-logo', 'assets/images/blogs', $blog->image2);
            }

            if (!is_null($request->image3)) {
                $blog->image3 = UploadHelper::update('image', $request->image3, Str::slug($request->title) . '-3' . time() . '-logo', 'assets/images/blogs', $blog->image3);
            }

            if (!is_null($request->image4)) {
                $blog->image4 = UploadHelper::update('image', $request->image4, Str::slug($request->title) . '-4' . time() . '-logo', 'assets/images/blogs', $blog->image4);
            }

            $blog->status = $request->status;
            $blog->description = $request->description;
            $blog->meta_description = $request->meta_description;
            $blog->updated_by = Auth::id();
            $blog->updated_at = Carbon::now();
            $blog->save();

            Track::newTrack($blog->title, 'Blog has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Blog has been updated successfully !!');
            return redirect()->route('admin.blogs.index');
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
        if (is_null($this->user) || !$this->user->can('blog.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $blog = Blog::find($id);
        if (is_null($blog)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.blogs.trashed');
        }
        $blog->deleted_at = Carbon::now();
        $blog->deleted_by = Auth::id();
        $blog->status = 0;
        $blog->save();

        session()->flash('success', 'Blog has been deleted successfully as trashed !!');
        return redirect()->route('admin.blogs.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('blog.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $blog = Blog::find($id);
        if (is_null($blog)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.blogs.trashed');
        }
        $blog->deleted_at = null;
        $blog->deleted_by = null;
        $blog->save();

        session()->flash('success', 'Blog has been revert back successfully !!');
        return redirect()->route('admin.blogs.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('blog.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $blog = Blog::find($id);
        if (is_null($blog)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.blogs.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('public/assets/images/blogs/' . $blog->image);

        // Delete Blog permanently
        $blog->delete();

        session()->flash('success', 'Blog has been deleted permanently !!');
        return redirect()->route('admin.blogs.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('blog.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

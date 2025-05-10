<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Part;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class PartsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('part.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        
        if (request()->ajax()) {
            if ($isTrashed) {
                $parts = Part::orderBy('part_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $parts = Part::orderBy('part_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($parts, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->part_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.parts.destroy', [$row->part_id]);
                            if ($this->user->can('part.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Part Details" href="' . route('admin.parts.edit', $row->part_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('part.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->part_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('part.delete')) {
                                $deleteRoute =  route('admin.parts.trashed.destroy', [$row->part_id]);
                                $revertRoute = route('admin.parts.trashed.revert', [$row->part_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->part_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->part_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Part Permanently" id="deleteItemPermanent' . $row->part_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('part.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->part_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Part will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->part_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->part_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Part will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->part_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->part_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Part will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->part_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->part_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->part_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('part_name', function ($row) {
                    return $row->part_name;
                })
                ->editColumn('part_image', function ($row) {
                    if ($row->part_image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('public/assets/images/parts/' . $row->part_image) . "' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'part_name', 'status', 'part_image'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_parts = count(Part::select('part_id')->get());
        $count_active_parts = count(Part::select('part_id')->where('status', 1)->get());
        $count_trashed_parts = count(Part::select('part_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.parts.index', compact('count_parts', 'count_active_parts', 'count_trashed_parts'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Part::whereIn('part_id', $ids)->delete();
           // session()->flash('success', 'New Part has been deleted successfully !!');
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
        if (is_null($this->user) || !$this->user->can('part.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.parts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if (is_null($this->user) || !$this->user->can('part.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'part_name'  => 'required|max:100',
            'slug'  => 'nullable|max:100|unique:wl_parts,slug',
            'part_image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $part = new Part();
            $part->part_name = $request->part_name;

            if ($request->slug) {
                $part->slug = StringHelper::createSlug($request->slug, 'Part', 'slug', '-');  
            } else {               
                $part->slug = StringHelper::createSlug($request->part_name, 'Part', 'slug', '-');                
            }

            if (!is_null($request->part_image)) {
                $part->part_image = UploadHelper::upload('image', $request->part_image, Str::slug($request->part_name) . '-' . time() . '-logo', 'public/assets/images/parts');
            }

            $part->status = $request->status;           
            $part->created_at = Carbon::now();
            $part->updated_at = Carbon::now();
            $part->save();

            Track::newTrack($part->part_name, 'New Part has been created');
            DB::commit();
            session()->flash('success', 'New Part has been created successfully !!');
            return redirect()->route('admin.parts.index');
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
        if (is_null($this->user) || !$this->user->can('part.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $part = Part::find($id);
        return view('backend.pages.parts.show', compact('part'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('part.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $part = Part::find($id);
        return view('backend.pages.parts.edit', compact('part'));
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
        if (is_null($this->user) || !$this->user->can('part.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $part = Part::find($id);
        if (is_null($part)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.parts.index');
        }

        $request->validate([
            'part_name'  => 'required|max:100',
            'slug'  => 'required|max:100|unique:wl_parts,slug,' . $part->part_id.',part_id',
            'part_image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $part->part_name = $request->part_name;
            $part->status = $request->status;

            if ($request->slug) {
                $part->slug = StringHelper::createSlug($request->slug, 'Part', 'slug', '-');  
            } else {               
                $part->slug = StringHelper::createSlug($request->part_name, 'Part', 'slug', '-');                
            }

            if (!is_null($request->part_image)) {
                $part->part_image = UploadHelper::update('image', $request->part_image, Str::slug($request->part_name) . '-' . time() . '-logo', 'public/assets/images/parts', $part->part_image);
            }

            $part->status = $request->status; 
            $part->updated_at = Carbon::now();
            $part->save();

            Track::newTrack($part->part_name, 'Part has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Part has been updated successfully !!');
            return redirect()->route('admin.parts.index');
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
        if (is_null($this->user) || !$this->user->can('part.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $part = Part::find($id);
        if (is_null($part)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.parts.trashed');
        }
        $part->deleted_at = Carbon::now();
        $part->status = 0;
        $part->save();

        session()->flash('success', 'Part has been deleted successfully as trashed !!');
        return redirect()->route('admin.parts.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('part.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $part = Part::find($id);
        if (is_null($part)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.parts.trashed');
        }
        $part->deleted_at = null;
        $part->save();

        session()->flash('success', 'Part has been revert back successfully !!');
        return redirect()->route('admin.parts.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('part.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $part = Part::find($id);
        if (is_null($part)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.parts.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('public/assets/images/parts/' . $part->image);

        // Delete Part permanently
        $part->delete();

        session()->flash('success', 'Part has been deleted permanently !!');
        return redirect()->route('admin.parts.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('part.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

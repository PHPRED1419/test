<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class SizesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('size.view')) { 
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

       

        if (request()->ajax()) {
            if ($isTrashed) {
                $sizes = Size::orderBy('size_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $sizes = Size::orderBy('size_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($sizes, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->size_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.sizes.destroy', [$row->size_id]);
                            if ($this->user->can('size.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Size Details" href="' . route('admin.sizes.edit', $row->size_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('size.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->size_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('size.delete')) {
                                $deleteRoute =  route('admin.sizes.trashed.destroy', [$row->size_id]);
                                $revertRoute = route('admin.sizes.trashed.revert', [$row->size_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->size_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->size_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Size Permanently" id="deleteItemPermanent' . $row->size_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('size.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->size_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Size will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->size_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->size_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Size will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->size_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->size_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Size will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->size_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->size_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->size_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('size_name', function ($row) {
                    return $row->size_name;
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
            $rawColumns = ['checkbox', 'action', 'size_name', 'status'];           
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_sizes = count(Size::select('size_id')->get());
        $count_active_sizes = count(Size::select('size_id')->where('status', 1)->get());
        $count_trashed_sizes = count(Size::select('size_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.sizes.index', compact('count_sizes', 'count_active_sizes', 'count_trashed_sizes'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Size::whereIn('size_id', $ids)->delete();
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
        if (is_null($this->user) || !$this->user->can('size.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('size.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'size_name' => 'required|max:100|unique:wl_sizes,size_name',
        ]);

        try {
            DB::beginTransaction();
            $size = new Size();
            $size->size_name = $request->size_name;           

            $size->status = $request->status;            
            $size->created_at = Carbon::now();
            $size->updated_at = Carbon::now();
            $size->save();

            Track::newTrack($size->size_name, 'New Size has been created');
            DB::commit();
            session()->flash('success', 'New Size has been created successfully !!');
            return redirect()->route('admin.sizes.index');
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
        if (is_null($this->user) || !$this->user->can('size.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $size = Size::find($id);
        return view('backend.pages.sizes.show', compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('size.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $size = Size::find($id);
        return view('backend.pages.sizes.edit', compact('size'));
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
        if (is_null($this->user) || !$this->user->can('size.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $size = Size::find($id);
        
        if (is_null($size)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.sizes.index');
        }

        $request->validate([
            'size_name' => 'required|max:100|unique:wl_sizes,size_name,' . $size->size_id . ',size_id',
        ]);

        try {
            DB::beginTransaction();
            $size->size_name = $request->size_name;
            $size->status = $request->status;
            $size->updated_at = Carbon::now();
            $size->save();

            Track::newTrack($size->size_name, 'Size has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Size has been updated successfully !!');
            return redirect()->route('admin.sizes.index');
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
        if (is_null($this->user) || !$this->user->can('size.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $size = Size::find($id);
        if (is_null($size)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.sizes.trashed');
        }
        $size->deleted_at = Carbon::now();
        //$size->deleted_by = Auth::id();
        $size->status = 0;
        $size->save();

        session()->flash('success', 'Size has been deleted successfully as trashed !!');
        return redirect()->route('admin.sizes.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('size.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $size = Size::find($id);
        if (is_null($size)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.sizes.trashed');
        }
        $size->deleted_at = null;
        $size->save();

        session()->flash('success', 'Size has been revert back successfully !!');
        return redirect()->route('admin.sizes.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('size.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $size = Size::find($id);
        if (is_null($size)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.sizes.trashed');
        }
        // Delete Blog permanently
        $size->delete();

        session()->flash('success', 'Size has been deleted permanently !!');
        return redirect()->route('admin.sizes.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('size.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

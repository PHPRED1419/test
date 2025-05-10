<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Flashe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class FlashesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('flashes.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        if (request()->ajax()) {
            if ($isTrashed) {
                $flashes = Flashe::orderBy('flash_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $flashes = Flashe::orderBy('flash_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($flashes, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->flash_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Flashe Details" href="' . route('admin.flashes.show', $row->flash_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.flashes.destroy', [$row->flash_id]);
                            if ($this->user->can('flashes.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Flashe Details" href="' . route('admin.flashes.edit', $row->flash_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('flashes.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->flash_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('flashes.delete')) {
                                $deleteRoute =  route('admin.flashes.trashed.destroy', [$row->flash_id]);
                                $revertRoute = route('admin.flashes.trashed.revert', [$row->flash_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->flash_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->flash_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Flashe Permanently" id="deleteItemPermanent' . $row->flash_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('flashes.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->flash_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Flashe will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->flash_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->flash_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Flashe will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->flash_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->flash_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Flashe will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->flash_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->flash_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->flash_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('flash_title', function ($row) {
                    return $row->flash_title;
                })
                ->editColumn('flash_image', function ($row) {
                    if ($row->flash_image != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/flashes/' . $row->flash_image) . "' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'flash_position', 'status', 'flash_image'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_flashes = count(Flashe::select('flash_id')->get());
        $count_active_flashes = count(Flashe::select('flash_id')->where('status', 1)->get());
        $count_trashed_flashes = count(Flashe::select('flash_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.flashes.index', compact('count_flashes', 'count_active_flashes', 'count_trashed_flashes'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Flashe::whereIn('flash_id', $ids)->delete();
           // session()->flash('success', 'New Flashe has been deleted successfully !!');
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
        if (is_null($this->user) || !$this->user->can('flashes.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.flashes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        if (is_null($this->user) || !$this->user->can('flashes.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }
    
        $request->validate([
            'flash_title'  => 'required|max:100',
            'flash_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
    
        try {
            DB::beginTransaction();
            
            // Ensure directory exists
            $targetDir = public_path('assets/images/flashes');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
    
            $flashe = new Flashe();
    
            if ($request->hasFile('flash_image')) {
                $image = $request->file('flash_image');
                $filename = time() . '-FLASH.' . $image->getClientOriginalExtension();
                
                // Store the file
                $path = $image->move($targetDir, $filename);
                
                // Save path relative to public folder
                $flashe->flash_image = $filename;
            }
            
            $flashe->flash_title = $request->flash_title; 
            $flashe->status = $request->status;           
            $flashe->created_at = Carbon::now();
            $flashe->updated_at = Carbon::now();
            $flashe->save();
            
            DB::commit();
            session()->flash('success', 'New Flashe has been created successfully !!');
            return redirect()->route('admin.flashes.index');
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
        if (is_null($this->user) || !$this->user->can('flashes.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $flashe = Flashe::find($id);
        return view('backend.pages.flashes.show', compact('flashe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('flashes.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $flashe = Flashe::find($id);
        return view('backend.pages.flashes.edit', compact('flashe'));
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
        if (is_null($this->user) || !$this->user->can('flashes.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $flashe = Flashe::find($id);
        if (is_null($flashe)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.flashes.index');
        }

        $request->validate([
            'flash_title'  => 'required|max:100',
            'flash_image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $flashe->status = $request->status;

            //$filename = time() . '-BANNER.' . $image->getClientOriginalExtension();

            if (!is_null($request->flash_image)) {
                $flashe->flash_image = UploadHelper::update('image', $request->flash_image, time() . '-FLASH', 'assets/images/flashes', $flashe->flash_image);
            }

            $flashe->flash_title = $request->flash_title; 
            $flashe->status = $request->status; 
            $flashe->updated_at = Carbon::now();
            $flashe->save();

            DB::commit();
            session()->flash('success', 'Flashe has been updated successfully !!');
            return redirect()->route('admin.flashes.index');
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
        if (is_null($this->user) || !$this->user->can('flashes.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $flashe = Flashe::find($id);
        if (is_null($flashe)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.flashes.trashed');
        }
        $flashe->deleted_at = Carbon::now();
        $flashe->status = 0;
        $flashe->save();

        session()->flash('success', 'Flashe has been deleted successfully as trashed !!');
        return redirect()->route('admin.flashes.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('flashes.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $flashe = Flashe::find($id);
        if (is_null($flashe)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.flashes.trashed');
        }
        $flashe->deleted_at = null;
        $flashe->save();

        session()->flash('success', 'Flashe has been revert back successfully !!');
        return redirect()->route('admin.flashes.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('flashes.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $flashe = Flashe::find($id);
        if (is_null($flashe)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.flashes.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('assets/images/flashes/' . $flashe->image);

        // Delete Flashe permanently
        $flashe->delete();

        session()->flash('success', 'Flashe has been deleted permanently !!');
        return redirect()->route('admin.flashes.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('flashes.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

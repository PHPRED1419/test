<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Color;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Services\ColorService;


class ColorsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('color.view')) { exit;
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

       

        if (request()->ajax()) {
            if ($isTrashed) {
                $colors = Color::orderBy('color_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $colors = Color::orderBy('color_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($colors, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->color_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.colors.destroy', [$row->color_id]);
                            if ($this->user->can('color.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Color Details" href="' . route('admin.colors.edit', $row->color_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('color.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->color_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('color.delete')) {
                                $deleteRoute =  route('admin.colors.trashed.destroy', [$row->color_id]);
                                $revertRoute = route('admin.colors.trashed.revert', [$row->color_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->color_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->color_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Color Permanently" id="deleteItemPermanent' . $row->color_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('color.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->color_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Color will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->color_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->color_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Color will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->color_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->color_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Color will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->color_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->color_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->color_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('color_code', function ($row) {
                    return "<div style='background-color: ".$row->color_code."; width: 410px;'>".$row->color_code."</div>";
                })

                ->editColumn('color_name', function ($row) {
                    return "<div>".$row->color_name."</div>";
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
            $rawColumns = ['checkbox', 'action', 'color_name', 'color_code', 'status'];           
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_colors = count(Color::select('color_id')->get());
        $count_active_colors = count(Color::select('color_id')->where('status', 1)->get());
        $count_trashed_colors = count(Color::select('color_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.colors.index', compact('count_colors', 'count_active_colors', 'count_trashed_colors'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Color::whereIn('color_id', $ids)->delete();
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
        if (is_null($this->user) || !$this->user->can('color.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('color.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'color_code' => 'required|max:100|unique:wl_colors,color_code',
        ]);

        $colorService = new ColorService();
        $color_name = $colorService->getColorNameByHex($request->color_code);

        try {
            DB::beginTransaction();
            $color = new Color();
            $color->color_name = $color_name;
            $color->color_code = $request->color_code;           

            $color->status = $request->status;            
            $color->created_at = Carbon::now();
            $color->updated_at = Carbon::now();
            $color->save();

            Track::newTrack($color->color_name, 'New Color has been created');
            DB::commit();
            session()->flash('success', 'New Color has been created successfully !!');
            return redirect()->route('admin.colors.index');
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
        if (is_null($this->user) || !$this->user->can('color.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $color = Color::find($id);
        return view('backend.pages.colors.show', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('color.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $color = Color::find($id);
        return view('backend.pages.colors.edit', compact('color'));
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
        if (is_null($this->user) || !$this->user->can('color.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $color = Color::find($id);
        
        if (is_null($color)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.colors.index');
        }

        $request->validate([
            'color_code' => 'required|max:100|unique:wl_colors,color_code,' . $color->color_id . ',color_id',
        ]);

        $colorService = new ColorService();
        $color_name = $colorService->getColorNameByHex($request->color_code);

        try {
            DB::beginTransaction();
            $color->color_code = $request->color_code;
            $color->color_name = isset($color_name) ? $color_name : '';
            $color->status = $request->status;
            $color->updated_at = Carbon::now();
            $color->save();

            Track::newTrack($color->color_name, 'Color has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Color has been updated successfully !!');
            return redirect()->route('admin.colors.index');
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
        if (is_null($this->user) || !$this->user->can('color.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $color = Color::find($id);
        if (is_null($color)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.colors.trashed');
        }
        $color->deleted_at = Carbon::now();
        //$color->deleted_by = Auth::id();
        $color->status = 0;
        $color->save();

        session()->flash('success', 'Color has been deleted successfully as trashed !!');
        return redirect()->route('admin.colors.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('color.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $color = Color::find($id);
        if (is_null($color)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.colors.trashed');
        }
        $color->deleted_at = null;
        $color->save();

        session()->flash('success', 'Color has been revert back successfully !!');
        return redirect()->route('admin.colors.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('color.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $color = Color::find($id);
        if (is_null($color)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.colors.trashed');
        }
        // Delete Blog permanently
        $color->delete();

        session()->flash('success', 'Color has been deleted permanently !!');
        return redirect()->route('admin.colors.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('color.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }

   
    public function getColorName(Request $request, ColorService $colorService)
    {
        $hexCode = $request->input('hex_code'); // Get HEX code from the request

        if (!$hexCode) {
            return response()->json([
                'success' => false,
                'message' => 'HEX code is required.',
            ], 400);
        }

        $colorName = $colorService->getColorNameByHex($hexCode);

        if ($colorName) {
            return response()->json([
                'success' => true,
                'color_name' => $colorName,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Color name not found.',
            ], 404);
        }
    }
}

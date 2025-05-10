<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class TestimonialsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('testimonials.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }       

        if (request()->ajax()) {
            if ($isTrashed) {
                $testimonials = Testimonial::orderBy('testimonial_id', 'desc')
                    ->where('status', '0')
                    ->get();
            } else {
                $testimonials = Testimonial::orderBy('testimonial_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($testimonials, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->testimonial_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Testimonial Details" href="' . route('admin.testimonials.show', $row->testimonial_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.testimonials.destroy', [$row->testimonial_id]);
                            if ($this->user->can('testimonials.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Testimonial Details" href="' . route('admin.testimonials.edit', $row->testimonial_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('testimonials.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->testimonial_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('testimonials.delete')) {
                                $deleteRoute =  route('admin.testimonials.trashed.destroy', [$row->testimonial_id]);
                                $revertRoute = route('admin.testimonials.trashed.revert', [$row->testimonial_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->testimonial_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->testimonial_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Testimonial Permanently" id="deleteItemPermanent' . $row->testimonial_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('testimonials.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->testimonial_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Testimonial will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->testimonial_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->testimonial_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Testimonial will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->testimonial_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->testimonial_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Testimonial will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->testimonial_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->testimonial_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->testimonial_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('name', function ($row) {
                    $row_details = '<b>Name: </b>'.$row->name;
                    $row_details .= '<br /><b>Email: </b>'.$row->email;
                    return $row_details;
                })
                ->editColumn('photo', function ($row) {
                    if ($row->photo != null) {
                        return "
                        <div id='img-viewer'>
                            <span class='close' onclick='close_model()'>&times;</span>
                            <img class='modal-content img-auto-width' id='full-image' >
                        </div>
                        
                        <div  class='img-container'>
                            <img src='" . asset('assets/images/testimonials/' . $row->photo) . "' style='width:70px !important;' class='img img-display-list img-source' onclick='full_view(this);' />
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
            $rawColumns = ['checkbox', 'action', 'name', 'status', 'photo'];
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_testimonials = count(Testimonial::select('testimonial_id')->get());
        $count_active_testimonials = count(Testimonial::select('testimonial_id')->where('status', 1)->get());
        $count_trashed_testimonials = count(Testimonial::select('testimonial_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.testimonials.index', compact('count_testimonials', 'count_active_testimonials', 'count_trashed_testimonials'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Testimonial::whereIn('testimonial_id', $ids)->delete();
           // session()->flash('success', 'New Testimonial has been deleted successfully !!');
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
        if (is_null($this->user) || !$this->user->can('testimonials.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('testimonials.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'name'  => 'required|max:100|unique:wl_testimonial,name',
            'email'  => 'nullable|max:200',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'  => 'required|max:1000',
        ]);

        try {
            DB::beginTransaction();
            $testimonial = new Testimonial();
            $testimonial->name = $request->name; 
            $testimonial->email = $request->email;           

            if (!is_null($request->photo)) {
                $testimonial->photo = UploadHelper::upload('photo', $request->photo, Str::slug($request->name) . '-' . time() . '-Testi', 'assets/images/testimonials');
            }

            $testimonial->status = $request->status;
            $testimonial->description = $request->description;
            $testimonial->created_at = Carbon::now();
            $testimonial->updated_at = Carbon::now();
            $testimonial->save();

            Track::newTrack($testimonial->name, 'New Testimonial has been created');
            DB::commit();
            session()->flash('success', 'New Testimonial has been created successfully !!');
            return redirect()->route('admin.testimonials.index');
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
        if (is_null($this->user) || !$this->user->can('testimonials.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $testimonial = Testimonial::find($id);
        return view('backend.pages.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('testimonials.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $testimonial = Testimonial::find($id);
        return view('backend.pages.testimonials.edit', compact('testimonial'));
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
        if (is_null($this->user) || !$this->user->can('testimonials.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $testimonial = Testimonial::find($id);
       
        if (is_null($testimonial)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.testimonials.index');
        }

        $request->validate([  
            'name' => 'required|max:100|unique:wl_testimonial,name,' . $testimonial->testimonial_id . ',testimonial_id',
            'email'  => 'nullable|max:200',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'  => 'required|max:1000',
        ]);

        try {
            DB::beginTransaction();
            $testimonial->name = $request->name;            
            $testimonial->email = $request->email;

            if (!is_null($request->photo)) {
                $testimonial->photo = UploadHelper::update('photo', $request->photo, Str::slug($request->name) . '-' . time() . '-Testi', 'assets/images/testimonials', $testimonial->photo);
            }

            $testimonial->status = $request->status;
            $testimonial->description = $request->description;
            $testimonial->updated_at = Carbon::now();
            $testimonial->save();

            Track::newTrack($testimonial->name, 'Testimonial has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Testimonial has been updated successfully !!');
            return redirect()->route('admin.testimonials.index');
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
        if (is_null($this->user) || !$this->user->can('testimonials.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $testimonial = Testimonial::find($id);
        if (is_null($testimonial)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.testimonials.trashed');
        }
        $testimonial->deleted_at = Carbon::now();
        $testimonial->status = 0;
        $testimonial->save();

        session()->flash('success', 'Testimonial has been deleted successfully as trashed !!');
        return redirect()->route('admin.testimonials.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('testimonials.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $testimonial = Testimonial::find($id);
        if (is_null($testimonial)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.testimonials.trashed');
        }
        $testimonial->deleted_at = null;
        $testimonial->save();

        session()->flash('success', 'Testimonial has been revert back successfully !!');
        return redirect()->route('admin.testimonials.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('testimonials.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $testimonial = Testimonial::find($id);
        if (is_null($testimonial)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.testimonials.trashed');
        }

        // Remove Image
        UploadHelper::deleteFile('assets/images/testimonials/' . $testimonial->photo);

        // Delete Testimonial permanently
        $testimonial->delete();

        session()->flash('success', 'Testimonial has been deleted permanently !!');
        return redirect()->route('admin.testimonials.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('testimonials.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

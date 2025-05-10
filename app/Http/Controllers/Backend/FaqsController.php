<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class FaqsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('faqs.view')) { 
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
     
        if (request()->ajax()) {
            if ($isTrashed) {
                $faqs = Faq::orderBy('faq_id', 'desc')
                    ->where('status', 0)
                    ->get();
            } else {
                $faqs = Faq::orderBy('faq_id', 'desc')
                    ->where('deleted_at', null)
                    ->where('status', 1)
                    ->get();
            }

            $datatable = DataTables::of($faqs, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->faq_id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $csrf = "" . csrf_field() . "";
                        $method_delete = "" . method_field("delete") . "";
                        $method_put = "" . method_field("put") . "";
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Faq Details" href="' . route('admin.faqs.show', $row->faq_id) . '"><i class="fa fa-eye"></i></a>';

                        if ($row->deleted_at === null) {
                            $deleteRoute =  route('admin.faqs.destroy', [$row->faq_id]);
                            if ($this->user->can('faqs.edit')) {
                                $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Faq Details" href="' . route('admin.faqs.edit', $row->faq_id) . '"><i class="fa fa-edit"></i></a>';
                            }
                            if ($this->user->can('faqs.delete')) {
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Admin" id="deleteItem' . $row->faq_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        } else {
                            if ($this->user->can('faqs.delete')) {
                                $deleteRoute =  route('admin.faqs.trashed.destroy', [$row->faq_id]);
                                $revertRoute = route('admin.faqs.trashed.revert', [$row->faq_id]);

                                $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle ml-1" title="Revert Back" id="revertItem' . $row->faq_id . '"><i class="fa fa-check"></i></a>';
                                $html .= '
                                <form id="revertForm' . $row->faq_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                            class="fa fa-check"></i> Confirm Revert</button>
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times"></i> Cancel</button>
                                </form>';
                                $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-1 text-white" title="Delete Faq Permanently" id="deleteItemPermanent' . $row->faq_id . '"><i class="fa fa-trash"></i></a>';
                            }
                        }

                        if ($this->user->can('faqs.delete')) {
                            $html .= '<script>
                            $("#deleteItem' . $row->faq_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Faq will be deleted as trashed !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deleteForm' . $row->faq_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#deleteItemPermanent' . $row->faq_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Faq will be deleted permanently, both from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!"
                                }).then((result) => { if (result.value) {$("#deletePermanentForm' . $row->faq_id . '").submit();}})
                            });
                        </script>';

                            $html .= '<script>
                            $("#revertItem' . $row->faq_id . '").click(function(){
                                swal.fire({ title: "Are you sure?",text: "Faq will be revert back from trash !",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, Revert Back!"
                                }).then((result) => { if (result.value) {$("#revertForm' . $row->faq_id . '").submit();}})
                            });
                        </script>';

                            $html .= '
                            <form id="deleteForm' . $row->faq_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';

                            $html .= '
                            <form id="deletePermanentForm' . $row->faq_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i
                                        class="fa fa-check"></i> Confirm Permanent Delete</button>
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </form>';
                        }
                        return $html;
                    }
                )

                ->editColumn('faq_name', function ($row) {
                    return $row->faq_name;
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
            $rawColumns = ['checkbox', 'action', 'faq_name', 'status'];           
            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        $count_faqs = count(Faq::select('faq_id')->get());
        $count_active_faqs = count(Faq::select('faq_id')->where('status', 1)->get());
        $count_trashed_faqs = count(Faq::select('faq_id')->where('deleted_at', '!=', null)->get());
        return view('backend.pages.faqs.index', compact('count_faqs', 'count_active_faqs', 'count_trashed_faqs'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Faq::whereIn('faq_id', $ids)->delete();
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
        if (is_null($this->user) || !$this->user->can('faqs.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('faqs.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'faq_question' => 'required|max:500|unique:wl_faq,faq_question',
            'faq_answer' => 'required|max:5000',
        ]);

        try {
            DB::beginTransaction();
            $faq = new Faq();
            $faq->faq_question = $request->faq_question; 
            $faq->faq_answer = $request->faq_answer;           

            $faq->status = $request->status;            
            $faq->created_at = Carbon::now();
            $faq->updated_at = Carbon::now();
            $faq->save();

            Track::newTrack($faq->faq_question, 'New Faq has been created');
            DB::commit();
            session()->flash('success', 'New Faq has been created successfully !!');
            return redirect()->route('admin.faqs.index');
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
        if (is_null($this->user) || !$this->user->can('faqs.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $faq = Faq::find($id);
        return view('backend.pages.faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('faqs.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $faq = Faq::find($id);
        return view('backend.pages.faqs.edit', compact('faq'));
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
        if (is_null($this->user) || !$this->user->can('faqs.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $faq = Faq::find($id);
        
        if (is_null($faq)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.faqs.index');
        }

        $request->validate([
            'faq_question' => 'required|max:500|unique:wl_faq,faq_question,' . $faq->faq_id . ',faq_id',
            'faq_answer' => 'required|max:5000',
        ]);

        try {
            DB::beginTransaction();
            $faq->faq_question = $request->faq_question;
            $faq->faq_answer = $request->faq_answer;
            $faq->status = $request->status;
            $faq->updated_at = Carbon::now();
            $faq->save();

            Track::newTrack($faq->faq_question, 'Faq has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Faq has been updated successfully !!');
            return redirect()->route('admin.faqs.index');
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
        if (is_null($this->user) || !$this->user->can('faqs.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $faq = Faq::find($id);
        if (is_null($faq)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.faqs.trashed');
        }
        $faq->deleted_at = Carbon::now();
        //$faq->deleted_by = Auth::id();
        $faq->status = 0;
        $faq->save();

        session()->flash('success', 'Faq has been deleted successfully as trashed !!');
        return redirect()->route('admin.faqs.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('faqs.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $faq = Faq::find($id);
        if (is_null($faq)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.faqs.trashed');
        }
        $faq->deleted_at = null;
        $faq->save();

        session()->flash('success', 'Faq has been revert back successfully !!');
        return redirect()->route('admin.faqs.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('faqs.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $faq = Faq::find($id);
        if (is_null($faq)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.faqs.trashed');
        }
        // Delete Blog permanently
        $faq->delete();

        session()->flash('success', 'Faq has been deleted permanently !!');
        return redirect()->route('admin.faqs.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('faqs.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Keyword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class KeywordsController extends Controller
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
    public function index(Request $request, $isTrashed = false)
	{
		if (is_null($this->user) || !$this->user->can('keywords.view')) {
			$message = 'You are not allowed to access this page !';
			return view('errors.403', compact('message'));
		}
	
		if ($request->ajax()) {
			$query = Keyword::query()->orderBy('kwid', 'desc');
	
			if ($isTrashed) {
				$query->onlyTrashed();
			} else {
				$query->where('status', 1);
			}
	
			return DataTables::eloquent($query)
				->addIndexColumn()
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="row-checkbox" value="' . $row->kwid . '">';
				})
				->addColumn('action', function ($row) use ($isTrashed) {
					// (reuse your HTML button code here)
					return '<a class="btn btn-sm btn-primary" href="' . route('admin.keywords.edit', $row->kwid) . '">Edit</a>';
				})
				->editColumn('status', function ($row) {
					if ($row->status) {
						return '<span class="badge badge-success">Active</span>';
					} elseif ($row->deleted_at) {
						return '<span class="badge badge-danger">Trashed</span>';
					} else {
						return '<span class="badge badge-warning">Inactive</span>';
					}
				})
				->rawColumns(['checkbox', 'action', 'status'])
				->make(true);
		}
	
		$count_keywords = Keyword::count();
		$count_active_keywords = Keyword::where('status', 1)->count();
		$count_trashed_keywords = Keyword::onlyTrashed()->count();
	
		return view('backend.pages.keywords.index', compact(
			'count_keywords', 'count_active_keywords', 'count_trashed_keywords'
		));
	}

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Keyword::whereIn('kwid', $ids)->delete();
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
        if (is_null($this->user) || !$this->user->can('keywords.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        return view('backend.pages.keywords.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('keywords.create')) {
            return abort(403, 'You are not allowed to access this page !');
        }

        $request->validate([
            'keywords_name' => 'required|max:100|unique:job_keywords,keywords_name',
        ]);

        try {
            DB::beginTransaction();
            $keywords = new Keyword();
            $keywords->keywords_name = $request->keywords_name;           

            $keywords->status = $request->status;            
            $keywords->created_at = Carbon::now();
            $keywords->updated_at = Carbon::now();
            $keywords->save();

            Track::newTrack($keywords->keywords_name, 'New keyword has been created');
            DB::commit();
            session()->flash('success', 'New keyword has been created successfully !!');
            return redirect()->route('admin.keywords.index');
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
        if (is_null($this->user) || !$this->user->can('keywords.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $keywords = Keyword::find($id) ;
        return view('backend.pages.keywords.show', compact('keywords'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('keywords.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $keywords = Keyword::find($id) ;
        return view('backend.pages.keywords.edit', compact('keywords'));
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
        if (is_null($this->user) || !$this->user->can('keywords.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $keywords = Keyword::find($id) ;
        
        if (is_null($keywords)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.keywords.index');
        }

        $request->validate([
            'keywords_name' => 'required|max:100|unique:job_keywords,keywords_name,' . $keywords->kwid . ',kwid',
        ]);

        try {
            DB::beginTransaction();
            $keywords->keywords_name = $request->keywords_name;
            $keywords->status = $request->status;
            $keywords->updated_at = Carbon::now();
            $keywords->save();

            Track::newTrack($keywords->keywords_name, 'keyword has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'keywords has been updated successfully !!');
            return redirect()->route('admin.keywords.index');
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
        if (is_null($this->user) || !$this->user->can('keywords.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $keywords = Keyword::find($id) ;
        if (is_null($keywords)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.keywords.trashed');
        }
        $keywords->deleted_at = Carbon::now();
        //$size->deleted_by = Auth::id();
        $keywords->status = 0;
        $keywords->save();

        session()->flash('success', 'keywords has been deleted successfully as trashed !!');
        return redirect()->route('admin.keywords.trashed');
    }

    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('keywords.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $keywords = Keyword::find($id) ;
        if (is_null($keywords)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.keywords.trashed');
        }
        $keywords->deleted_at = null;
        $keywords->save();

        session()->flash('success', 'keywords has been revert back successfully !!');
        return redirect()->route('admin.keywords.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('keywords.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $keywords = Keyword::find($id) ;
        if (is_null($keywords)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.keywords.trashed');
        }
        // Delete Blog permanently
        $keywords->delete();

        session()->flash('success', 'keywords has been deleted permanently !!');
        return redirect()->route('admin.keywords.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('keywords.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
    }
}

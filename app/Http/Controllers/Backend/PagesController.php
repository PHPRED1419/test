<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\Pages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class PagesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('pages.view')) { 
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

   

    if (request()->ajax()) {
        if ($isTrashed) {
            $pages = Pages::orderBy('id', 'desc')
                ->where('status', 0)
                ->get();
        } else {
            $pages = Pages::orderBy('id', 'desc')
                //->where('deleted_at', null)
                ->where('status', 1)
                ->get();
        }

        $datatable = DataTables::of($pages, $isTrashed)
            ->addIndexColumn()           
            ->addColumn(
                'action',
                function ($row) use ($isTrashed) {
                    $csrf = "" . csrf_field() . "";
                    $method_delete = "" . method_field("delete") . "";
                    $method_put = "" . method_field("put") . "";
                    $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View" href="' . route('admin.pages.show', $row->id) . '"><i class="fa fa-eye"></i></a>';
                    
                    if ($this->user->can('pages.edit')) {
                        $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle ml-1 " title="Edit Page" href="' . route('admin.pages.edit', $row->id) . '"><i class="fa fa-edit"></i></a>';
                    }                                      

                    return $html;
                }
            )

            ->editColumn('title', function ($row) {
                return $row->title;
            })
            
            ->editColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-success font-weight-100">Active</span>';
                }
            });
        $rawColumns = ['checkbox', 'action', 'title', 'status'];           
        return $datatable->rawColumns($rawColumns)
            ->make(true);
    }

    $count_pages = count(Pages::select('id')->get());
    $count_active_pages = count(Pages::select('id')->where('status', 1)->get());
    $count_trashed_pages = count(Pages::select('id')->where('deleted_at', '!=', null)->get());
    return view('backend.pages.pages.index', compact('count_pages', 'count_active_pages', 'count_trashed_pages'));

    }

    
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('pages.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $page = Pages::find($id);
        return view('backend.pages.pages.edit', compact('page'));
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
        if (is_null($this->user) || !$this->user->can('pages.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $pages = Pages::find($id);
        if (is_null($pages)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.pages.index');
        }

        $request->validate([
            'description' => 'nullable|string',
            'image'  => 'nullable|image||max:2048'
        ]);

        try {
            DB::beginTransaction();
            $pages->description = $request->description;  

            if (!is_null($request->image)) {
                $pages->image = UploadHelper::update('image', $request->image, Str::slug($request->title) . '-' . time() . '-page', 'public/assets/images/pages', $pages->image);
            }
            
            $pages->meta_description = $request->meta_description;
            $pages->updated_by = Auth::id();
            $pages->updated_at = Carbon::now();
            $pages->save();

            Track::newTrack($pages->title, 'Page has been updated successfully !!');
            DB::commit();
            session()->flash('success', 'Page has been updated successfully !!');
            return redirect()->route('admin.pages.index');
        } catch (\Exception $e) {
            session()->flash('sticky_error', $e->getMessage());
            DB::rollBack();
            return back();
        }
    }

    public function show($id)
    {
        if (is_null($this->user) || !$this->user->can('pages.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $pages = Pages::find($id);
        return view('backend.pages.pages.show', compact('pages'));
    }

    public function uploadMedia(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
    
            // Save the file to the public storage directory
            $path = storage_path('app/public/uploads');
            $request->file('upload')->move($path, $fileName);
    
            // Generate the URL to the uploaded file
            $url = asset('storage/app/public/uploads/' . $fileName); // Correct URL
    
            // Debugging: Log the URL
            \Log::info('Generated URL: ' . $url);
    
            // Return the response to CKEditor
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
    
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        } else {
            // Debugging statement
            dd($request->all());
        }
        return false;
    }
}

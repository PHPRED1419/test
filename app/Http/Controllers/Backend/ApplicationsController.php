<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Models\ApplicationsCategory;
use App\Models\Application;

use App\Models\Brand;

use App\Models\ApplicationMedia;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ApplicationsController extends Controller
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
        // Check user permissions
        if (is_null($this->user) || !$this->user->can('application.view')) {
            $message = 'You are not allowed to access this page!';
            return view('errors.403', compact('message'));
        }
    
        // Define fields and conditions
        $fields = 'wlp.*';
        $rev_cond = 'status=1 AND ';
    
        // Build the query
        $data_res = DB::table('wl_applications as wlp')
            ->select(DB::raw("SQL_CALC_FOUND_ROWS {$fields}, 
                wlp.status as application_status, 
                wlpm.media, 
                wlpm.media_type, 
                wlpm.is_default"))
            ->leftJoin('wl_applications_media as wlpm', 'wlp.applications_id', '=', 'wlpm.applications_id')
            ->where('wlp.status', '!=', '2');      
       
        if (request()->ajax()) {
            
            if ($isTrashed) {
                $applications = $data_res->orderBy('wlp.applications_id', 'desc')
                    ->where('wlp.status', '0')                     
                    ->groupBy('wlp.applications_id')
                    ->get();
            } else {
                $applications = $data_res->orderBy('wlp.applications_id', 'desc') 
                    //->whereNull('wlp.deleted_at')                  
                    ->where('wlp.status', '1') 
                    ->groupBy('wlp.applications_id')
                    ->get();
            }
            
            //$sql = $data_res->toSql();
            //$bindings = $data_res->getBindings();
            //dd($sql, $bindings);

            // Build DataTable response
            $datatable = DataTables::of($applications)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->applications_id . '">';
                })
                ->addColumn('action', function ($row) use ($isTrashed) {
                    $csrf = csrf_field();
                    $method_delete = method_field('delete');
                    $method_put = method_field('put');
                    $html = '';
    
                    if ($row->deleted_at === null) {
                        $deleteRoute = route('admin.applications.destroy', [$row->applications_id]);
                        if ($this->user->can('application.edit')) {
                            $html .= '<a class="btn waves-effect waves-light btn-success btn-sm btn-circle" title="Edit Product" href="' . route('admin.applications.edit', $row->applications_id) . '"><i class="fa fa-edit"></i></a>';
                        }
                        if ($this->user->can('application.delete')) {
                            $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-2 text-white" title="Delete Product" id="deleteItem' . $row->applications_id . '"><i class="fa fa-trash"></i></a>';
                        }
                    } elseif ($this->user->can('application.delete')) {
                        $deleteRoute = route('admin.applications.trashed.destroy', [$row->applications_id]);
                        $revertRoute = route('admin.applications.trashed.revert', [$row->applications_id]);
    
                        $html .= '<a class="btn waves-effect waves-light btn-warning btn-sm btn-circle" title="Revert Back" id="revertItem' . $row->applications_id . '"><i class="fa fa-check"></i></a>';
                        $html .= '<form id="revertForm' . $row->applications_id . '" action="' . $revertRoute . '" method="post" style="display:none">' . $csrf . $method_put . '
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i class="fa fa-check"></i> Confirm Revert</button>
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        </form>';
                        $html .= '<a class="btn waves-effect waves-light btn-danger btn-sm btn-circle ml-2 text-white" title="Delete Permanently" id="deleteItemPermanent' . $row->applications_id . '"><i class="fa fa-trash"></i></a>';
                    }
    
                    // Add JavaScript for confirmation dialogs
                    $html .= '<script>
                        $("#deleteItem' . $row->applications_id . '").click(function() {
                            swal.fire({ title: "Are you sure?", text: "Product will be deleted as trashed!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!" })
                                .then((result) => { if (result.value) { $("#deleteForm' . $row->applications_id . '").submit(); } });
                        });
                        $("#deleteItemPermanent' . $row->applications_id . '").click(function() {
                            swal.fire({ title: "Are you sure?", text: "Product will be deleted permanently!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, delete it!" })
                                .then((result) => { if (result.value) { $("#deletePermanentForm' . $row->applications_id . '").submit(); } });
                        });
                        $("#revertItem' . $row->applications_id . '").click(function() {
                            swal.fire({ title: "Are you sure?", text: "Product will be reverted from trash!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, revert it!" })
                                .then((result) => { if (result.value) { $("#revertForm' . $row->applications_id . '").submit(); } });
                        });
                    </script>';
    
                    // Add delete forms
                    $html .= '
                    <form id="deleteForm' . $row->applications_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i class="fa fa-check"></i> Confirm Delete</button>
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </form>
                    <form id="deletePermanentForm' . $row->applications_id . '" action="' . $deleteRoute . '" method="post" style="display:none">' . $csrf . $method_delete . '
                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-success"><i class="fa fa-check"></i> Confirm Permanent Delete</button>
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </form>                     
                    ';

                    // Add button to trigger modal
                /*$html .= '<button type="button" class="btn btn-primary custom-modal-botton" data-toggle="modal" data-target="#exampleModal" onclick="loadModalData(' . $row->applications_id . ', \'' . $row->application_name . '\', \'' . $row->application_code . '\')">Update Stock</button>';
                */
    
                    return $html;
                })
                ->editColumn('application_name', function ($row) {
                    return $row->application_name;
                })
                ->editColumn('application_code', function ($row) {
                    return $row->application_code;
                })               
                ->editColumn('media', function ($row) {
                    if ($row->media) {
                        return '
                        <div id="img-viewer">
                            <span class="close" onclick="close_model()">&times;</span>
                            <img class="modal-content" id="full-image">
                        </div>
                        <div class="img-container">
                            <img src="' . asset('assets/images/applications/' . $row->media) . '" class="img img-display-list img-source" onclick="full_view(this);" style="width:100px;">
                        </div>';
                    }
                    return '-';
                })              
               
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success font-weight-100">Active</span>';
                    } elseif ($row->deleted_at) {
                        return '<span class="badge badge-danger">Trashed</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->rawColumns(['checkbox', 'action', 'application_name', 'application_code','status', 'priority', 'media'])
                ->make(true);

            return $datatable;
           
        }
        
        // Get counts for the view
        $count_applications = Application::count();
        $count_active_applications = Application::where('status', '1')->count();
        $count_trashed_applications = Application::whereNotNull('deleted_at')->count();

        return view('backend.applications.index', compact('count_applications', 'count_active_applications', 'count_trashed_applications'));
    }

       

    public function deleteMultiple(Request $request)
    {
        // Check user permissions
        if (is_null($this->user) || !$this->user->can('application.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to access this page!',
            ], 403); // 403 Forbidden
        }

        // Get the IDs from the request
        $ids = $request->input('ids');

        // Validate the input
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No application IDs provided!',
            ], 400); // 400 Bad Request
        }

        DB::beginTransaction();
        try {
            Application::whereIn('applications_id', $ids)->delete();
            ApplicationMedia::whereIn('applications_id', $ids)->delete();
            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Products and related records deleted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting applications: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the applications!',
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $application = new Application();     
        
        $image_counter = 6;
        return view('backend.applications.create', compact('application','image_counter'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 

    public function store(Request $request)
    {
        // Check user permissions
        if (is_null($this->user) || !$this->user->can('application.create')) {
            return abort(403, 'You are not allowed to access this page!');
        }
    
        // Validate the request
        $request->validate([
            'parent_category_id' => 'required',
            'application_name' => 'required|max:100|unique:wl_applications,application_name',
            'slug' => 'nullable|max:100|unique:wl_applications,slug',
            'applications_description' => 'nullable|string',
            'application_images*' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:500', // Validate each image
        ]);
    
        // Begin database transaction
        DB::beginTransaction();
        
        $application = new Application();    

        try {
            $image_counter = 6;

            if ($request->slug) {
                $application->slug = $request->slug;  
            } else {                           
                $application->slug = StringHelper::createSlug($request->application_name, 'Application', 'slug', '-');   
            }
            
            // Create a new application
           
            $application->fill([
                'application_name' => $request->application_name,              
                'category_id' => $request->parent_category_id,
                'application_alt' => $request->application_alt ?? '',
                'applications_description' => $request->applications_description,
                'status' => $request->status ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $application->save();
   
            // Update priority based on the last application's priority
            $lastProductPriorityValue = Application::orderBy('priority', 'desc')->value('priority');
            if (!is_null($lastProductPriorityValue)) {
                $application->priority = (int) $lastProductPriorityValue + 1;
                $application->save();
            }
    
            $processed_images = [];

            for ($i = 1; $i <= $image_counter; $i++) {
                $input_name = 'application_images_' . $i;
                $existing_media_name = 'existing_media_' . $i;

                if ($request->hasFile($input_name)) {
                    if ($request->$existing_media_name) {
                        UploadHelper::delete('assets/images/applications/' . $request->$existing_media_name);
                    }

                    // Upload the new media
                    $media = UploadHelper::upload(
                        $input_name,
                        $request->file($input_name),
                        'application_images-' . $application->applications_id . '-' . $i . '-' . time(),
                        'assets/images/applications'
                    );

                    // Create new media record (don't update existing)
                    $productMedia = ApplicationMedia::create([
                        'applications_id' => $application->applications_id,
                        'media_type' => 'photo',
                        'media' => $media,
                        'is_default' => $i === 1 ? 'Y' : 'N',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $processed_images[] = $productMedia->id;

                } elseif ($request->$existing_media_name) {
                    // Find existing media record for this position
                    $existingMedia = ApplicationMedia::where('applications_id', $application->products_id)
                        ->where('media', $request->$existing_media_name)
                        ->first();

                    if ($existingMedia) {
                        $existingMedia->update([
                            'is_default' => $i === 1 ? 'Y' : 'N',
                            'updated_at' => Carbon::now(),
                        ]);
                        $processed_images[] = $existingMedia->id;
                    }
                }
            }

            // Delete any media records that weren't processed (removed by user)
            if (!empty($processed_images)) {
                ApplicationMedia::where('applications_id', $application->applications_id)
                    ->where('media_type', 'photo')
                    ->whereNotIn('id', $processed_images)
                    ->delete();
            }
    
            $applicationId = $application->applications_id;
        
            // Log the action
            Track::newTrack($application->application_name, 'New Application has been created');
    
            // Commit the transaction
            DB::commit();
    
            session()->flash('success', 'New Application has been created successfully!');
            return redirect()->route('admin.applications.index');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            session()->flash('sticky_error', $e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('application.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $image_counter = 6;
        $application   = Application::find($id);
        $medias = ApplicationMedia::where('applications_id', $id)->get();
        
        return view('backend.applications.edit', compact('application','medias','image_counter'));
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

        // Check user permissions
        if (is_null($this->user) || !$this->user->can('application.edit')) {
            return abort(403, 'You are not allowed to access this page!');
        }

        // Validate the request
        $request->validate([
            'parent_category_id' => 'required',
            'application_name' => 'required|max:100|unique:wl_applications,application_name,' . $id . ',applications_id', 
            'slug' => 'nullable|max:100|unique:wl_applications,slug,' . $id . ',applications_id', 
           
            'applications_description' => 'nullable|string',
            'application_images*' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:500', 
        ]);

        // Begin database transaction
        DB::beginTransaction();

        try {
            $image_counter = 6;
            $medias = ApplicationMedia::where('applications_id', $id)->get();

            $application = Application::findOrFail($id);
            
            if ($request->slug) {
                $application->slug = $request->slug;  
            } else {               
                $application->slug = StringHelper::createSlug($request->application_name, 'Application', 'slug', '-');                
            }

            // Retrieve the existing application           
            $application->fill([
                'application_name' => $request->application_name,                
                'category_id' => $request->parent_category_id,
                'application_alt' => $request->application_alt ?? '',
                'applications_description' => $request->applications_description, 
                'status' => $request->status ?? 1,
                'updated_at' => Carbon::now(),
            ]);
            $application->save();           

            for ($i = 1; $i <= $image_counter; $i++) {
                $input_name = 'application_images_' . $i;
                $existing_media_name = 'existing_media_' . $i;
                $delete_check_name = 'delete_check_' . $i;

            if(!isset($request->$delete_check_name)){

                if ($request->hasFile($input_name)) {
                    if ($request->$existing_media_name) {
                        $existingMedia = ApplicationMedia::find($request->$existing_media_name);
                        if ($existingMedia && $existingMedia->media) {
                            UploadHelper::delete('assets/images/applications/' . $existingMedia->media);
                        }
                    }

                    // Upload the new media
                    $media = UploadHelper::upload(
                        $input_name, 
                        $request->file($input_name), 
                        'application_images-' . $i . '-' . time(), 
                        'assets/images/applications' 
                    );

                    // Update or create the media record
                    ApplicationMedia::updateOrCreate(
                        [
                            'id' => $request->$existing_media_name, 
                        ],
                        [
                            'applications_id' => $application->applications_id,
                            'media_type' => 'photo',
                            //'product_code' => $product->product_code,
                            'media' => $media,
                            'is_default' => $i === 1 ? 'Y' : 'N', 
                            'updated_at' => Carbon::now(),
                        ]
                    );
                } elseif ($request->$existing_media_name) {
                    ApplicationMedia::updateOrCreate(
                        [
                            'id' => $request->$existing_media_name, 
                        ],
                        [
                            'applications_id' => $application->applications_id,
                            'media_type' => 'photo',
                            //'product_code' => $product->product_code,
                            'is_default' => $i === 1 ? 'Y' : 'N', 
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }else{

                 #########Delete Image here
                if (!is_null($request->$existing_media_name)) {  
                    $id = $request->$existing_media_name;
                    DB::table('wl_applications_media')
                    ->where('id', $id)
                    ->update([
                        'media' => ''
                    ]);
                }
                #########################
            }
            }

            Track::newTrack($application->application_name, 'Application has been updated');
            DB::commit();

            session()->flash('success', 'Application has been updated successfully!');
            return redirect()->route('admin.applications.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('sticky_error', $e->getMessage());
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
        if (is_null($this->user) || !$this->user->can('application.delete')) {
            $message = 'You are not allowed to access this page!';
            return view('errors.403', compact('message'));
        }

        // Find the application by its primary key
        $application = Application::find($id);

        // Debugging: Check if the application is found
        if (is_null($application)) {
            session()->flash('error', "The application is not found!");
            return redirect()->route('admin.applications.trashed');
        }

        // Soft delete the application
        $application->deleted_at = Carbon::now();
       // $application->deleted_by = Auth::id();
        $application->status = 0;
        $application->save();

        session()->flash('success', 'Application has been deleted successfully as trashed!');
        return redirect()->route('admin.applications.trashed');
    }
    /**
     * revertFromTrash
     *
     * @param integer $id
     * @return Remove the item from trash to active -> make deleted_at = null
     */
    public function revertFromTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('category.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $application = Application::find($id);
        if (is_null($application)) {
            session()->flash('error', "The page is not found !");
            return redirect()->route('admin.applications.trashed');
        }
        $application->deleted_at = null;
        //$application->deleted_by = null;
        $application->save();

        session()->flash('success', 'Product has been revert back successfully !!');
        return redirect()->route('admin.applications.trashed');
    }

    /**
     * destroyTrash
     *
     * @param integer $id
     * @return void Destroy the data permanently
     */
    public function destroyTrash($id)
    {
        if (is_null($this->user) || !$this->user->can('application.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $application = Application::find($id);
        if (is_null($application)) {
            session()->flash('error', "The application is not found !");
            return redirect()->route('admin.applications.trashed');
        }
        // Remove Images
        UploadHelper::deleteFile('public/assets/images/applications/' . $application->media);
        // Delete Product permanently
        $application->delete();

        // Delete Product Images permanently
        $application_media = ApplicationMedia::where('applications_id', $id);        
        if (is_null($application_media)) {
            session()->flash('error', "The media is not found !");
            return redirect()->route('admin.applications.trashed');
        }       
        $application_media->delete();
                
        session()->flash('success', 'Product has been deleted permanently !!');
        return redirect()->route('admin.applications.trashed');
    }

    /**
     * trashed
     *
     * @return view the trashed data list -> which data status = 0 and deleted_at != null
     */
    public function trashed()
    {
        if (is_null($this->user) || !$this->user->can('application.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        return $this->index(true);
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
            $url = asset('storage/app/public/uploads/' . $fileName);

            // Return the response to CKEditor
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
        return false;
    }


}

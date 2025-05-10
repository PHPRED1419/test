<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ContactusEnquiryController extends Controller
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
        if (is_null($this->user) || !$this->user->can('product_enquiry.view')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }

        $query = ContactEnquiry::orderBy('status', 'asc');

        if (request()->ajax()) {
            $contacts = $query->get();

            $contactsDataTable = DataTables::of($contacts, $isTrashed)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })
                ->addColumn(
                    'action',
                    function ($row) use ($isTrashed) {
                        $html = '<a class="btn waves-effect waves-light btn-info btn-sm btn-circle" title="View Contact Details" href="contact_enquiry/show/'.$row->id .'"><i class="fa fa-eye"></i></a>';
                        return $html;
                    }
                )
                
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('jS F Y');
                })
                
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success font-weight-100">Viewed</span>';
                    } else {
                        return '<span class="badge badge-warning">Not Viewed</span>';
                    }
                });

            $rawColumns = ['checkbox','action', 'email', 'message', 'status'];
            return $contactsDataTable->rawColumns($rawColumns)
                ->make(true);
        }

        return view('backend.pages.contact_enquiry.index', [
            'total_messages' => $query->count()
        ]);
    }

    public function show($id)
    {
        $contact = ContactEnquiry::find($id);
        // Make status as viewed.
        //$contact->status = 1;
       // $contact->admin_id = $this->user->id;
       // $contact->save();
        // dd($contact);
        // Show contact.

        $contact->status = 1;
        $contact->save();

        return view('backend.pages.contact_enquiry.show', compact('contact'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            ContactEnquiry::whereIn('id', $ids)->delete();
           // session()->flash('success', 'New Part has been deleted successfully !!');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}

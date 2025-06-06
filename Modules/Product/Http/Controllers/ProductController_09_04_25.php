<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
//use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\DB; 
use App\Models\ProductEnquiry; 
use App\Models\InstantOfferEnquiry;
use Modules\Product\Emails\ProductEnquiryMail;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {       
        $categorySlug = request()->segment(2);  
                
        $query = Product::query()
        ->leftJoin('wl_products_media', function($join) {
            $join->on('wl_products.products_id', '=', 'wl_products_media.products_id')
                ->where('wl_products_media.is_default', '=', 'Y');
        })
        ->select('wl_products.*', 'wl_products_media.media');

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $query->where('wl_products.category_id', $category->id);
            }
        }

        $categoryId = $request->query('category_id', '');         
        $category = new Category();
        #echo $childCategories = $category->getCategoryLinks($categoryId);
        if ($categoryId) {
            $query->where('wl_products.category_id', $categoryId);
        }

        $productName = $request->query('product_name', ''); 
        if (!empty($productName)) {
            $query->where('product_name', 'LIKE', "%{$productName}%");
        }

        $query->where('wl_products.status', '1');
        $query->where('wl_products.product_type', '1');
        $products = $query->get();

        // Get categories with their subcategories
    /*$categories = Category::parentCategories()
    ->with(['subcategories'])
    ->where('status','1')
    ->get();  
    */

    $categories = Category::where('status', '1')
                ->whereNull('parent_category_id')
                ->get();

    //dd($categories);

        return view('product::index', compact('products','categories'));
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
   // app/Http/Controllers/ProductController.php

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
        ->leftJoin('wl_products_media', function($join) {
            $join->on('wl_products.products_id', '=', 'wl_products_media.products_id')
                ->where('wl_products_media.is_default', '=', 'Y');
        })
        ->firstOrFail();
       
        $media = DB::table('wl_products_media')
            ->where('products_id', $product->products_id)
            ->get();
      
        return view('product::details', [
            'product' => $product,
            'media' => $media
        ]);
    }

    public function submitEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:wl_products,products_id',
            'name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|integer',
            //'quantity' => 'nullable|integer|min:1',
            //'company' => 'nullable|string|max:255',
            //'country' => 'nullable|string|max:100',
           // 'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
            //'g-recaptcha-response' => 'required|recaptcha',
        ]/*, [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification',
            'g-recaptcha-response.recaptcha' => 'Invalid reCAPTCHA response'
        ]*/);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $product = Product::findOrFail($request->product_id);
    
        // Save enquiry to database
        $enquiry = ProductEnquiry::create([
            'product_id' => $product->products_id,
            'product_name' => $product->product_name,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            //'quantity' => $request->quantity ?? 1,
           // 'subject' => $request->subject ?? 'Enquiry about ' . $product->name,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
    
        // Send email notification
        /*Mail::to(config('mail.enquiry_recipient'))
            ->cc($request->email) // Optional: CC the sender
            ->send(new ProductEnquiryMail($product, $enquiry));
    
        // Optional: Send confirmation to the user
        Mail::to($request->email)
            ->send(new EnquiryConfirmationMail($product, $enquiry));
        */
        return redirect()
            ->back()
            ->with('success', 'Thank you for your enquiry! We will contact you soon.');
    }

    public function instant_offer(Request $request)
    {
        $data = [];
        return view('product::instant_offer', compact('data'));
    }


    
    
    public function submitOfferEnquiry(Request $request)
{       
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|regex:/^[\pL\s\-\']+$/u|max:255',
        'country' => 'required|string|max:100',
        'email' => 'required|email|max:255',
        'nationalCode' => 'required|string|max:20',
        'mobile' => [
            'required',
            'string',
            'max:20',
            'regex:/^[0-9\s\-\(\)]{7,20}$/'
        ],
        'company' => 'nullable|string|max:255',
        'currentbusiness' => 'required',
        'salesturnover' => 'required',
        'pastexperience' => 'required|array',
        'pastexperience.*' => '',
        
        // SECTION B: MODEL SELECTION
        'purposefor' => 'required|array',
        'purposefor.*' => '',
        'choosemodel' => 'nullable|string|max:255',
        'modelcapacity' => 'required',
        'safety' => 'nullable|array',
        'safety.*' => '',
        'mobilenumber' => 'nullable|string|max:20|regex:/^[0-9\s\-\(\)]{7,20}$/',
        'website' => 'nullable|url|max:255',
        'installation' => 'required|string|max:100',
        'timeline' => 'required',
        'discount' => 'nullable',
        'message' => 'required|string|max:1000',
        //'g-recaptcha-response' => 'required|recaptcha',
    ], [
        'name.regex' => 'The name may only contain letters, spaces, hyphens and apostrophes',
        'mobile.regex' => 'Please enter a valid phone number',
        'pastexperience.required' => 'Please select at least one past experience option',
        'purposefor.required' => 'Please select at least one purpose',
        'currentbusiness.required' => 'Please select your current business/profession',
        'salesturnover.required' => 'Please select your sales turnover',
        'modelcapacity.required' => 'Please select model capacity',
        'timeline.required' => 'Please select expected timeline',
        'installation.required' => 'Please provide installation country',
        //'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification',
        //'g-recaptcha-response.recaptcha' => 'Invalid reCAPTCHA response'
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Process the form data
    $pastexperience = is_array($request->pastexperience) ? implode(', ', $request->pastexperience) : '';
    $purposefor = is_array($request->purposefor) ? implode(', ', $request->purposefor) : '';
    $safety = is_array($request->safety) ? implode(', ', $request->safety) : '';

    $enquiry = InstantOfferEnquiry::create([
        'name' => $request->name,
        'country' => $request->country,
        'email' => $request->email,
        'national_code' => $request->nationalCode,
        'mobile' => $request->mobile,
        'company' => $request->company,
        'current_business' => $request->currentbusiness,
        'sales_turnover' => $request->salesturnover,
        'past_experience' => $pastexperience,
        'purpose_for' => $purposefor,
        'choose_model' => $request->choosemodel,
        'model_capacity' => $request->modelcapacity,
        'safety_features' => $safety,
        'mobile_number' => $request->mobilenumber,
        'website' => $request->website,
        'installation_country' => $request->installation,
        'timeline' => $request->timeline,
        'expected_discount' => $request->discount,
        'message' => $request->message,
        'ip_address' => $request->ip(),
        'user_agent' => $request->header('User-Agent'),
    ]);

   // dd($enquiry);
    //exit;
    
    return redirect()
        ->back()
        ->with('success', 'Thank you for your enquiry! We will contact you soon.');
    }
}

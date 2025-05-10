<?php

namespace Modules\Service\Http\Controllers;

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

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {       
        $query = Product::query()
        ->leftJoin('wl_products_media', function($join) {
            $join->on('wl_products.products_id', '=', 'wl_products_media.products_id')
                ->where('wl_products_media.is_default', '=', 'Y');
        })
        ->select('wl_products.*', 'wl_products_media.media');
        $query->where('wl_products.status', '1');
        $query->where('wl_products.product_type', '2');
        $services = $query->get();
       
        return view('service::index', compact('services'));
    }


}

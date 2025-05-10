<?php

namespace Modules\Pages\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 
use Modules\Pages\Entities\Pages;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $slug = $request->segment(1);
        $page = Pages::where('slug', $slug)->first(); 
        return view('pages::index', compact('page'));
    }

    public function contact_us(Request $request)
    {        
       // $page = Pages::where('slug', $slug)->first(); 
       $page = [];
       return view('pages::contact_us', compact('page'));
    }

    public function contact_us_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Data is valid, proceed with saving
        $validated = $validator->validated();

        // Send email (uncomment when ready)
        // Mail::to('info@universalboschi.net')->send(new ContactFormSubmission($validated));

        // Save enquiry to database
        $inserted = DB::table('wl_enquiry')->insert([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'message' => $validated['message'],           
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
        
        return redirect()
        ->back()
        ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function sitemap(Request $request)
    {
        $data = [];
        return view('pages::sitemap', compact('data'));
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            //'email' => 'required|email|max:255|unique:wl_newsletter,email',
           // 'captcha' => 'required|captcha'
        ], [
            'email.unique' => 'This email is already subscribed!',
            //'captcha.captcha' => 'Invalid CAPTCHA code!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
       
        $inserted = DB::table('wl_newsletter')->insert([
            'email' => $request->email,
            'status' => 0,     
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
        

        return redirect()
        ->back()
        ->with('success', 'Thank you for contacting us! We will get back to you soon.');
        
        //return response()->json([
           // 'message' => 'Thank you for subscribing to our newsletter!'
       // ]);
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
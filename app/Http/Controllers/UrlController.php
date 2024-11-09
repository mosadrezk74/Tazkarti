<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid URL'], 422);
        }

        $originalUrl = $request->input('url');
        $shortCode = Url::generateShortCode();

        $url = Url::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode
        ]);

        return response()->json(['short_url' => url($shortCode)]);
    }

    // Redirect to original URL
    public function redirect($code)
    {
        $url = Url::where('short_code', $code)->firstOrFail();

        return redirect()->away($url->original_url);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CsrfTokenController extends Controller
{
    public function generateToken(Request $request)
    {
        $token = Str::random(60); // Generate a random token
        $request->user()->update(['api_csrf_token' => $token]);

        return response()->json(['token' => $token]);
    }
}

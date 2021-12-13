<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthTestController extends Controller
{

    public function fun(Request $request)
    {
        $token = $request->bearerToken();
        return response()->json([
            $token
        ], 200);
    }
}

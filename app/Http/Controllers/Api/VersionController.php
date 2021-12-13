<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function version()
    {
        $version = Settings::all()->first();

        return response()->json([
            'version' => $version->version,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDiceTron;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function changePasss(Request $request)
    {
        $user = Auth::user();
        $userData = UserDiceTron::find($user->id);
        $userData->password = Hash::make($request->password);
        $userData->save();

        return response()->json([
            'status' => 1,
            'message' => 'password change'
        ], 200);
    }
}

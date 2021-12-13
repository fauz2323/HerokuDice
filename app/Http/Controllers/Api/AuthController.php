<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogGame;
use App\Models\User;
use App\Models\UserDiceTron;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = UserDiceTron::where('username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $user->tokens()->delete();
            $token = $user->createToken('user_token')->plainTextToken;
            return response()->json([
                'message' => 'success login',
                'token' => $token,
                'data' => $user->wallet->tronAddress,
            ], 200);
        } else {
            return response()->json([
                'message' => 'user/password not found'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $userCheck = UserDiceTron::where('username', $request->username)->first();
        if ($userCheck) {
            return response()->json([
                'message' => 'username has been used'
            ], 201);
        } else {
            $paseoCreate = Http::post('https://paseo.live/paseo/New');
            sleep(1);
            $data3 = json_decode($paseoCreate);
            $user = UserDiceTron::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'balance' => 0,
                'reff' => $request->reff,
            ]);

            $user->history()->create([
                'id_akun' => $user->id,
                'payIn' => 0,
                'payOut' => 0,
            ]);

            $token = $user->createToken('user_token')->plainTextToken;

            $keyTron = Crypt::encrypt($data3->data->privateKey);
            $user->wallet()->create([
                'id_akun' => $user->id,
                'tronAddress' => $data3->data->address,
                'key' => $keyTron,
            ]);

            return response()->json([
                'username' => $user->username,
                'tronAddress' => $user->wallet->tronAddress,
                'key' => $keyTron,
                'token' => $token,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'logout success'
        ], 200);
    }

    public function getBalance()
    {
        $user = Auth::user();
        $balance = round(floatval($user->balance), 6);
        $profit = LogGame::where('id_akun', $user->id)->get();


        return response()->json([
            'Balance' => $balance,
            'profit' => number_format($profit->sum('bet'), 6),
            'maxProfit' => $profit->max('payOut'),
            'minProfit' => $profit->min('payOut'),
            'bonus' => $user->bonus,
            'cashback' => $user->wager,
        ],);
    }
}

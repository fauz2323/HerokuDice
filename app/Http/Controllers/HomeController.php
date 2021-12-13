<?php

namespace App\Http\Controllers;

use App\Models\MainWallet;
use App\Models\UserDiceTron;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $wallet = MainWallet::all()->first();
        $balance = Http::asForm()->post('https://paseo.live/ak12/CekSaldo', [
            'walletAddress' => $wallet->tronAddress
        ]);
        $balanceUser = UserDiceTron::all()->sum('balance');
        $user = [];
        $mounth = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

        foreach ($mounth as $key) {
            $user[] = UserDiceTron::whereMonth('created_at', $key)->count();
        }

        $jsonData = json_decode($balance);
        return view('home', compact('jsonData', 'balanceUser', 'user'));
    }
}

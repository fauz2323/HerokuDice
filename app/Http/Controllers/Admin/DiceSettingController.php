<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainWallet;
use Illuminate\Http\Request;

class DiceSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wallet = MainWallet::all()->first();
        return view('setting.dice.index', compact('wallet'));
    }
}

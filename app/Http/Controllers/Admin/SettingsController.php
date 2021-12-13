<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dice;
use App\Models\LogGame;
use App\Models\MainWallet;
use App\Models\SettingProfit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bonus = SettingProfit::first();
        $cost = MainWallet::first();
        return view('setting.dice.index', compact('bonus', 'cost'));
    }

    public function bonusStore(Request $request)
    {
        $bonus = SettingProfit::first();
        $bonus->update([
            'manajementProfit' => $request->manajementProfit,
            'itProfit' => $request->itProfit,
            'lvl1' => $request->lvl1,
            'lvl2' => $request->lvl2,
            'lvl3' => $request->lvl3,
            'wagerBonus' => $request->wagerBonus,
        ]);

        return redirect()->route('setting');
    }

    public function costSore(Request $request)
    {
        $cost = MainWallet::first();
        $cost->costWd = $request->costWd;
        $cost->save();

        return redirect()->route('setting');
    }

    public function diffStore(Request $request)
    {
        $cost = MainWallet::first();
        $cost->diff = $request->diff;
        $cost->save();

        return redirect()->route('setting');
    }

    public function passChange(Request $request)
    {
        $auth = Auth::user();
        $userData = User::where('id', $auth->id)->first();
        if (Hash::check($request->old, $userData->password)) {
            $userData->password = Hash::make($request->newPass);
            $userData->save();

            return redirect()->route('home')->with('message', 'Change password Success');
        } else {
            return redirect()->route('viewChangePass')->with('error', 'Old Password Not Match');
        }
    }

    public function ttt()
    {
        $data = Dice::where('status', 1)->take(201);
        $data->update([
            'status' => 0
        ]);

        return response()->json(['sss'], 200);
    }

    public function bba()
    {
        $data = LogGame::sum('bet');
        return response()->json([$data], 200);
    }

    public function changePass()
    {
        return view('setting.changePass');
    }

    public function topStore(Request $request)
    {
        $data = MainWallet::first();
        $data->divider = $request->top;
        $data->save();

        return redirect()->route('setting');
    }
}

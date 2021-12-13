<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wallet = MainWallet::all()->first();
        return view('setting.wallet.index', compact('wallet'));
    }

    public function change(Request $request, $id)
    {
        $wallet = MainWallet::findOrFail($id);
        $wallet->update([
            'tronAddress' => $request->address,
            'key' => Crypt::encrypt($request->key)
        ]);

        return redirect()->route('walletSettings');
    }
}

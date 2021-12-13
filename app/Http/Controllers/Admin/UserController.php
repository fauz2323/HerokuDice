<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\UserDiceTron;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = UserDiceTron::with('history')->where('visible', 1);

            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="detail/' . $row->id . '/user" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editCustomer">Detail</a>';
                    return $btn;
                })->addColumn('total', function ($user) {
                    $total =  ($user->balance + $user->history->payOut) - $user->history->payIn;
                    return round($total, 6);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user.index');
    }

    public function detail($number)
    {
        $user = UserDiceTron::findOrFail($number);

        $depo = Deposit::where('id_akun', $number)->simplePaginate(15);
        $wd = Withdraw::where('id_akun', $number)->simplePaginate(15);

        return view('user.detail', compact('user', 'depo', 'wd'));
        // dd($user);
    }

    public function change(Request $request, $id)
    {
        $user = UserDiceTron::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user-list');
    }

    public function addBonus()
    {
        $userData = UserDiceTron::all();
        foreach ($userData as $key) {
            $key->balance = $key->balance + $key->bonus;
            $key->bonus = 0;
            $key->save();
        }

        return redirect()->route('user-list');
    }
}

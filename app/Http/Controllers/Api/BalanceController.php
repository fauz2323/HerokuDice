<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\History;
use App\Models\MainWallet;
use App\Models\UserDiceTron;
use App\Models\UserWallet;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class BalanceController extends Controller
{


    public function historyWd()
    {
        $user = Auth::user();
        $dataHistory = Withdraw::where('id_akun', $user->id)->get();

        return response()->json([
            'History' => $dataHistory
        ], 200);
    }

    public function historyDeposit()
    {
        $user = Auth::user();
        $dataHistory = Deposit::where('id_akun', $user->id)->get();

        return response()->json([
            'History' => $dataHistory
        ], 200);
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        $userData = UserDiceTron::findOrFail($user->id);
        $historyBalance = History::where('id_akun', $user->id)->first();
        $decrypted = Crypt::decrypt($userData->wallet->key);
        $mainWallet = MainWallet::all()->first();

        $response = Http::asForm()->post('https://paseo.live/paseo/SendTron', [
            'senderAddress' => $userData->wallet->tronAddress,
            'senderPrivateKey' => $decrypted,
            'receiverAddress' => $mainWallet->tronAddress,
            'amount' => $request->pay,
        ]);
        $dataJson = json_decode($response);

        try {
            if ($dataJson->data->result == true) {
                $totals = $request->pay + 0.3;

                $userData->balance = $userData->balance + $totals;
                $userData->save();

                $code = 'DPTRX-' . rand(100000, 999999);

                Deposit::create([
                    'id_akun' => $user->id,
                    'codeTransaction' => substr($code, 0, 12),
                    'total' => round($totals, 6),
                    'wallet' => $user->wallet->tronAddress,
                ]);

                if ($historyBalance) {
                    $historyBalance->payIn = $historyBalance->payIn + ($request->pay + 0.1);
                    $historyBalance->save();
                } else {
                    History::create([
                        'id_akun' => $user->id,
                        'payIn' => round($totals, 6),
                        'payOut' => 0,
                    ]);
                }

                return response()->json([
                    'message' => 'sucess',
                    'balance' => $userData->balance,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'error',
                    'balance' => $userData->balance,
                ], 202);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'balance' => $userData->balance,
            ], 203);
        }
    }

    public function addBalancePending(Request $request)
    {
        $user = UserDiceTron::findOrfail($request->id);
        $historyBalance = History::where('id_akun', $user->id)->first();

        if ($request->code == "hanyaRequestBiasaSajaDanHanyaRequest") {
            if ($user) {
                $user->balance = $user->balance + $request->balance;
                $user->save();
                $code = 'DPTRX-' . rand(100000, 999999);

                Deposit::create([
                    'id_akun' => $user->id,
                    'codeTransaction' => substr($code, 0, 12),
                    'total' => round($request->balance, 6),
                    'wallet' => $user->wallet->tronAddress,
                ]);

                if ($historyBalance) {
                    $historyBalance->payIn = $historyBalance->payIn + ($request->balance);
                    $historyBalance->save();
                } else {
                    History::create([
                        'id_akun' => $user->id,
                        'payIn' => round($request->balance, 6),
                        'payOut' => 0,
                    ]);
                }
                return response()->json("okey", 200);
            }
        }
    }

    public function wd(Request $request)
    {
        $user = Auth::user();
        $userData = UserDiceTron::where('id', $user->id)->first();
        $wallets = MainWallet::all()->first();
        $dec = Crypt::decrypt($wallets->key);
        $amount = $request->totalWd - $wallets->costWd; //totlas wd
        $histori = History::where('id_akun', $user->id)->first();

        if ($user->balance >= $request->totalWd) {
            $response = Http::acceptJson()->asForm()->post('https://paseo.live/paseo/SendTron', [
                'senderAddress' => $wallets->tronAddress,
                'senderPrivateKey' => $dec,
                'receiverAddress' => $request->address,
                'amount' => $amount,
            ]);
            $jsonData = json_decode($response);

            if ($jsonData->success == true) {
                $userData->balance = $userData->balance - $amount;
                $userData->save();

                $code = 'WDTRX-' . rand(100000, 999999);

                Withdraw::create([
                    'id_akun' => $user->id,
                    'codeTransaction' => substr($code, 0, 12),
                    'wallet' => $request->address,
                    'total' => $request->totalWd,
                ]);

                if ($histori) {
                    $histori->payOut = $histori->payOut + $request->totalWd;
                    $histori->save();
                } else {
                    History::create([
                        'id_akun' => $user->id,
                        'payIn' => 0,
                        'payOut' => $request->totalWd
                    ]);
                }

                return response()->json([
                    'amount' => $amount,
                    'key' => $dec,
                    'add' => $request->address,
                    'wallet' => $wallets->tronAddress,
                    'data' => json_decode($response),
                    'message' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'Error' => 'Error'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'balance incuifment'
            ], 201);
        }
    }

    public function transfer(Request $request)
    {
        $auth = Auth::user();
        $usersender = UserDiceTron::findOrFail($auth->id);
        $userReciever = UserDiceTron::where('username', $request->username)->first();
        $historyBalance = History::where('id_akun', $auth->id)->first();

        if ($usersender->balance > $request->pay) {
            if ($userReciever) {
                $usersender->balance = $usersender->balance - $request->pay;
                $usersender->save();

                $userReciever->balance = $userReciever->balance + $request->pay;
                $userReciever->save();

                Deposit::create([
                    'id_akun' => $userReciever->id,
                    'codeTransaction' => "transfer",
                    'total' => round($request->pay, 6),
                    'wallet' => $usersender->username,
                ]);

                if ($historyBalance) {
                    $historyBalance->payIn = $historyBalance->payIn + ($request->pay);
                    $historyBalance->save();
                } else {
                    History::create([
                        'id_akun' => $auth->id,
                        'payIn' => round($request->pay, 6),
                        'payOut' => 0,
                    ]);
                }

                return response()->json([
                    'message' => $usersender->balance,
                ], 200);
                # code...
            } else {
                return response()->json([
                    'message' => 'failed'
                ], 201);
            }
        } else {
            return response()->json([
                'message' => 'failed balance'
            ], 203);
        }
    }

    public function getBonus()
    {
        $auth = Auth::user();
        $user = UserDiceTron::findOrFail($auth->id);

        if ($user) {
            $user->update([
                'balance' => $user->balance + $user->wager,
                'wager' => '0',
            ]);

            return response()->json([
                'message' => 'Success',
                'balance' => $user->balance,
                'wager' => $user->wager,
            ], 200);
        } else {
            return response()->json(['message' => 'Error'], 202);
        }
    }
}

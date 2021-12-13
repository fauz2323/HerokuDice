<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AkunTester;
use App\Models\Dice;
use App\Models\LogGame;
use App\Models\LogTester;
use App\Models\SettingProfit;
use App\Models\UserDiceTron;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiceController extends Controller
{
    public function dice(Request $request)
    {
        $datauser = Auth::user();
        $dice = Dice::inRandomOrder()->where('status', 1)->first();
        $user = UserDiceTron::findOrFail($datauser->id);
        $settingProfit = SettingProfit::all()->first();
        $userreff1 = UserDiceTron::where('username', $datauser->reff)->first();


        $itakun = UserDiceTron::where('username', 'itmanager')->first();
        $management = UserDiceTron::where('username', 'management')->first();
        $bonus1 = 0.05 / 100 * $request->pay; //bonus lvl1
        $bonus2 = 0.035 / 100 * $request->pay; //bonus lvl2
        $bonus3 = 0.015 / 100 * $request->pay; //bonus lvl3
        $bonusit = $settingProfit->itProfit / 100 * $request->pay; //bonus it
        $bonusmanagement = $settingProfit->manajementProfit / 100 * $request->pay; //bonus management
        $probability = 50;
        if ($request->high < 50) {
            $probability = 50;
        } else {
            $probability = $request->high - $request->low;
        }

        $pay = (floor(($settingProfit->divider / $probability) * 100) / 100) * $request->pay;
        $floorr = number_format($pay, 6, '.', '');
        $payOut = round($request->pay, 6);

        if ($request->pay > 0.0000009) {
            if ($userreff1) {

                $userreff1->bonus = $userreff1->bonus + $bonus1;
                $userreff1->save();
                $userreff2 = UserDiceTron::where('username', $userreff1->reff)->first();

                if ($userreff2) {
                    $userreff2->bonus = $userreff2->bonus + $bonus2;
                    $userreff2->save();
                    $userreff3 = UserDiceTron::where('username', $userreff2->reff)->first();

                    if ($userreff3) {
                        $userreff3->bonus = $userreff3->bonus + $bonus3;
                        $userreff3->save();
                    }
                }
            }

            if ($itakun) {
                $itakun->bonus = $itakun->bonus + $bonusit;
                $itakun->save();
            }
            if ($management) {
                $management->bonus = $management->bonus + $bonusmanagement;
                $management->save();
            }

            if ($user->balance <= $request->pay) {
                return response()->json([
                    'message' => 'incuifment ballance'
                ], 201);
            } else {
                if ($dice->number < $probability) {
                    $user->balance = $user->balance + (floatval($floorr) - $request->pay);
                    $user->wager = $user->wager + (($settingProfit->wagerBonus / 100) * $request->pay);
                    $user->save();
                    LogGame::create([
                        'id_akun' => $user->id,
                        'username' => $user->username,
                        'bet' => $payOut,
                        'high' => $request->high,
                        'payOut' => floatval($floorr),
                        'result' => 'win',
                        'number' => $dice->number,
                    ]);

                    return response()->json(['message' => 'win', 'number' => $dice->number, 'payOut' => floatval($floorr), 'balance' => $user->balance, 'Bet' => $request->pay, 'Prob' => $probability], 200,);
                } else {
                    $user->balance = $user->balance - $payOut;
                    $user->wager = $user->wager + (($settingProfit->wagerBonus / 100) * $request->pay);
                    $user->save();
                    LogGame::create([
                        'id_akun' => $user->id,
                        'username' => $user->username,
                        'bet' => $payOut,
                        'high' => $request->high,
                        'payOut' => round(0 - $payOut, 6),
                        'result' => 'lose',
                        'number' => $dice->number,
                    ]);

                    return response()->json(['message' => 'lose', 'number' => $dice->number, 'payOut' => 0 - $payOut, 'balance' => $user->balance, 'Bet' => $request->pay, 'Prob' => $probability], 200);
                }
            }
        } else {
            return response()->json("Error", 500);
        }
    }

    public function history()
    {
        $user = Auth::user();
        $dataDice = LogGame::where('id_akun', $user->id)->orderBy('created_at', 'desc')->take(50)->get();

        return response()->json($dataDice, 200);
    }

    public function multiBet(Request $request)
    {
        $datauser = Auth::user();
        $user = UserDiceTron::where('username', $datauser->username)->first();
        $settingProfit = SettingProfit::all()->first();
        $userreff1 = AkunTester::where('username', $user->reff)->first();
        $itakun = AkunTester::where('username', 'itmanager')->first();
        $management = AkunTester::where('username', 'management')->first();



        if ($request->pay > 0.0000009 && $user->balance > $request->pay) {
            $dice = Dice::first();
            $ressult = [];
            $message = '';
            $win = 0;
            $lose = 0;
            $pay = 0;
            $low = 0;
            $profit = 0;
            $profitTotal = 0;
            $bonus = 0;
            $bonus2 = 0;
            $bonus3 = 0;
            $bonusIT1 = 0;
            $bonusmanagement1 = 0;
            $balanceReal = $user->balance;
            $maxBet = $request->maxBet;
            $totalPayIn = 0;
            $totalPayOut = 0;
            $payWager = 0;

            if ($dice->status == 1) {
                $low = 70;
            } else {
                $low = 120;
            }

            //roll dice
            $base = $request->pay;
            for ($i = 1; $i <= $request->banyak; $i++) {
                if ($balanceReal > $base) {
                    $totalPayIn = $totalPayIn + $base;
                    $number = rand($low, 999);
                    $bonus = $bonus + (0.05 / 100 * $base);
                    $bonus2 = $bonus2 + (0.035 / 100 * $base);
                    $bonus3 = $bonus3 + (0.015 / 100 * $base);
                    $bonusIT1 = $bonusIT1 + (0.15 / 100 * $base);
                    $bonusmanagement1 = $bonusmanagement1 + (0.3 / 100 * $base);
                    $payWager = $payWager + (0.05 / 100 * $base);

                    if ($number < $request->high) {
                        $pay = (floor((992 / $request->high) * 100) / 100) * $base;
                        $profit = $pay - $base;
                        $message = "WIN";
                        $win++;
                        $balanceReal = $balanceReal + $profit;
                        $base = $base * $request->increase;

                        LogGame::create([
                            'id_akun' => $user->id,
                            'username' => $user->username,
                            'bet' => number_format($base, ".", ''),
                            'high' => $request->high,
                            'payOut' => floatval($pay),
                            'result' => 'win',
                            'number' => $dice->number,
                        ]);
                    } else {
                        $message = "Lose";
                        $lose++;
                        $pay = 0;
                        $profit = 0 - $base;
                        $balanceReal = $balanceReal + $profit;

                        $base = $base * $request->increaseLose;

                        LogGame::create([
                            'id_akun' => $user->id,
                            'username' => $user->username,
                            'bet' => number_format($base, ".", ''),
                            'high' => $request->high,
                            'payOut' => $profit,
                            'result' => 'Lose',
                            'number' => $dice->number,
                        ]);
                    }

                    $dadu = [
                        'dadu' => $number,
                        'message' => $message,
                        'Pay' => $pay,
                        'profit' => $profit,
                    ];
                    $ressult[] = $dadu;
                    $profitTotal = $profitTotal + $profit;

                    if ($base >= $maxBet) {
                        if ($request->maxBetIn == 1) {
                            break;
                        } else {
                            $base = $request->pay;
                        }
                    }
                    $totalPayOut = $totalPayOut + $pay;
                } else {
                    break;
                }
            } //end roll

            $ress = [
                'res' => $ressult,
                'base' => $request->pay,
                'payIn' => $totalPayIn,
                'payOut' => $totalPayOut,
                'win' => $win,
                'lose' => $lose,
                'totalProfit' => $profitTotal,
                'balance' => number_format($balanceReal, 6, '.', ''),
                'totalBet' => count($ressult),
            ];
            $user->balance = floatval(number_format($balanceReal, 6, '.', ''));
            $user->wager = floatval(number_format($payWager, 6, '.', ''));
            $user->save();

            if ($userreff1) {
                $userreff1->bonus = $userreff1->bonus + number_format($bonus, 6, ".", '');
                $userreff1->save();
                $userreff2 = AkunTester::where('username', $userreff1->reff)->first();

                if ($userreff2) {
                    $userreff2->bonus = $userreff2->bonus + number_format($bonus2, 6, ".", '');
                    $userreff2->save();
                    $userreff3 = AkunTester::where('username', $userreff2->reff)->first();

                    if ($userreff3) {
                        $userreff3->bonus = $userreff3->bonus + number_format($bonus3, 6, ".", '');
                        $userreff3->save();
                    }
                }
            }


            if ($itakun) {
                $itakun->bonus = $itakun->bonus + number_format($bonusIT1, 6, ".", '');
                $itakun->save();
            }
            if ($management) {
                $management->bonus = $management->bonus + number_format($bonusmanagement1, 6, ".", '');
                $management->save();
            }


            return response()->json([
                'ressult' => $ress,
            ], 200);
        } else {
            return response()->json([
                'message' => "ERROR",
            ], 501);
        }
    }

    public function a(Request $request)
    {
        # code...
        $user = AkunTester::where('username', 'tester1')->first();

        $user->update([
            'balance' => $request->a,
            'bonus' => $request->b,
        ]);

        return response()->json("okke");
    }
}

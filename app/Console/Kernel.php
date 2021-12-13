<?php

namespace App\Console;

use App\Models\Dice;
use App\Models\LogGame;
use App\Models\MainWallet;
use App\Models\UserDiceTron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $wallet = MainWallet::all()->first();

            $params = Http::post('https://paseo.live/paseo/CekSaldo', [
                'walletAddress' => $wallet->tronAddress,
            ]);
            sleep(2);
            $res = json_decode($params);
            $UserDice = UserDiceTron::all()->sum('balance');
            $check = Dice::find(102);
            $realBalance = $res->data->trxbalance / 1000000 - $UserDice;
            if ($realBalance <= $wallet->diff) {
                if ($check->status == 1) {
                    $data = Dice::where('status', 1)->take(201);
                    $data->update([
                        'status' => 0
                    ]);
                }
            } else {
                $data = Dice::where('status', 0)->take(201);
                $data->update([
                    'status' => 1
                ]);
            }
        })->everyMinute();

        $schedule->call(function () {
            LogGame::truncate();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

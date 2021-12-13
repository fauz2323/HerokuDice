<?php

namespace Database\Seeders;

use App\Models\MainWallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MainWallet::create([
            'tronAddress' => "test",
            'key' => Crypt::encrypt("test"),
            'costWd' => 1,
            'diff' => 2331,
        ]);
    }
}

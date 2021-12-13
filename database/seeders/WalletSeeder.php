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
            'tronAddress' => "TTRJ9oh2TSTgRGFwwsKkbAemMt9Lox9Duv",
            'key' => Crypt::encrypt("6f8387c6e58f9c08c71869174ad2942d6b720aa6332f9cf703f1e7a70e90e084"),
            'costWd' => 1,
            'diff' => 2331,
            'divider' => 112,
        ]);
    }
}

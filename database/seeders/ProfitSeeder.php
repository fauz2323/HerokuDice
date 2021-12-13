<?php

namespace Database\Seeders;

use App\Models\SettingProfit;
use Illuminate\Database\Seeder;

class ProfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingProfit::create([
            'itProfit' => 0.05,
            'manajementProfit' => 0.05,
        ]);
    }
}

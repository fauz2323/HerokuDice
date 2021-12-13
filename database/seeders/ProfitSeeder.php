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
            'manajementProfit' => 0.05,
            'itProfit' => 0.05,
            'lvl1' => 0.05,
            'lvl2' => 0.05,
            'lvl3' => 0.05,
            'wagerBonus' => 0.05,
        ]);
    }
}

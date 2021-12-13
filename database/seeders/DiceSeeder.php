<?php

namespace Database\Seeders;

use App\Models\Dice;
use Illuminate\Database\Seeder;

class DiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 1000; $i++) {
            Dice::create([
                'number' => $i,
                'status' => 1,
            ]);
        }
    }
}

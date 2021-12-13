<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_profits', function (Blueprint $table) {
            $table->id();
            $table->double('itProfit');
            $table->double('manajementProfit');
            $table->double('lvl1');
            $table->double('lvl2');
            $table->double('lvl3');
            $table->double('divider');
            $table->double('wagerBonus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_profits');
    }
}

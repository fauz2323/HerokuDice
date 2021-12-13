<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_testers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_akun');
            $table->string('username');
            $table->string('bet');
            $table->string('high');
            $table->string('payOut');
            $table->string('result');
            $table->string('number');
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
        Schema::dropIfExists('log_testers');
    }
}

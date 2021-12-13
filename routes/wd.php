<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthTestController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\DiceController;
use App\Http\Controllers\Api\SettingsAPi;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/







Route::prefix('wd')->middleware('throttle:1,1')->group(function () {

    Route::middleware(['auth:sanctum'])->group(function () {

    });
});

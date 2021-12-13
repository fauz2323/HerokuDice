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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('deposit', [BalanceController::class, 'deposit']);
    Route::get('getCashback', [BalanceController::class, 'getBonus']);


    Route::get('balance', [AuthController::class, 'getBalance']);

    Route::get('historyWd', [BalanceController::class, 'historyWd']);
    Route::get('historydepo', [BalanceController::class, 'historyDeposit']);
    Route::post('transfer', [BalanceController::class, 'transfer']);

    Route::post('changePass', [SettingsAPi::class, 'changePasss']);

    Route::post('dice', [DiceController::class, 'dice']);
    Route::get('historyDice', [DiceController::class, 'history']);
    Route::post('ttes', [DiceController::class, 'multiBet']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('fun', [AuthTestController::class, 'fun']);

route::post('adds', [BalanceController::class, 'addBalancePending']);
route::post('c2a', [BalanceController::class, 'aaaa']);


Route::middleware(['auth:sanctum', 'throttle:some'])->group(function () {
    Route::get('aa', [BalanceController::class, 'historyWd']);
    Route::post('wd', [BalanceController::class, 'wd']);
});

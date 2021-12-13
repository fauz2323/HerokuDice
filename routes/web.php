<?php

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Api\DiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(
    [
        'register' => false,
    ]
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user', [UserController::class, 'index'])->name('user-list');
Route::get('detail/{id}/user', [UserController::class, 'detail'])->name('detail-user');
Route::post('change/{id}/paswword', [UserController::class, 'change'])->name('change-userpass');

Route::get('logGame', [LogController::class, 'index'])->name('logGame');

Route::get('walletSettings', [WalletController::class, 'index'])->name('walletSettings');
Route::post('storeWallet/{id}', [WalletController::class, 'change'])->name('walletStore');

Route::get('settings', [SettingsController::class, 'index'])->name('setting');
Route::post('bonusStore', [SettingsController::class, 'bonusStore'])->name('bonus.setting');
Route::post('costStore', [SettingsController::class, 'costSore'])->name('cost.setting');
Route::post('diffStore', [SettingsController::class, 'diffStore'])->name('diffStore.setting');

Route::get('addBonus', [UserController::class, 'addBonus'])->name('bonusAdd');
Route::post('StorePass', [SettingsController::class, 'passChange'])->name('changePass');

Route::get('changepass', [SettingsController::class, 'changePass'])->name('viewChangePass');

Route::post('topStore', [SettingsController::class, 'topStore'])->name('topStore');

Route::get('testest', [SettingsController::class, 'ttt']);
Route::get('bba', [SettingsController::class, 'bba']);

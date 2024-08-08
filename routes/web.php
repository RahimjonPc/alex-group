<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HookController;
use App\Http\Controllers\PromoCodeController;

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
    return view('welcome');
});

// set hook
Route::get('set/hook', [HookController::class, 'setHook']);

// delete hook
Route::get('delete/hook', [HookController::class, 'deleteHook']);

// url for getting response from telegram
Route::post('hook-x628798uaysr', [HookController::class, 'hook']);

// export promocodes to exel
Route::get('used/promocodes/export/', [PromoCodeController::class, 'exportUsedPromoCode'])->name('used_promocodes');
Route::get('new/promocodes/export/', [PromoCodeController::class, 'exportNewPromoCode'])->name('new_promocodes');

// voyager admin panel urls
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

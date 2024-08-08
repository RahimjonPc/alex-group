<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HookController;

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

Route::get('set/hook', [HookController::class, 'setHook']);
Route::get('delete/hook', [HookController::class, 'deleteHook']);
Route::post('hook-x628798uaysr', [HookController::class, 'hook']);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

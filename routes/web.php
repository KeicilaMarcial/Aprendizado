<?php

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
    return view('welcome');
});
Route::group(['middleware' => ['api']], function () {
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Route::group(['middleware' => ['common_user']], function () {
    //     Route::get('/newTransaction', [app\Http\Controllers\UserController::class, 'newTransaction']);
    //     Route::get('/transaction/{value}/{payer}/{payeer}', [App\Http\Controllers\WalletController::class, 'transaction']);
    // });
});
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


Route::group(['middleware' => ['web']], function () {
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');

    Route::group(['middleware' => ['common_user']], function () {
        // Route::get('common_user', function () {
        //     dd("Go Common!!");
        // });
        Route::get('/transaction', [App\Http\Controllers\UserController::class, 'payment']);
        Route::get('/transaction/{value}/{payer}/{payeer}', [App\Http\Controllers\WalletController::class, 'transaction']);
        
    });

    Route::group(['middleware' => ['shopkeeper_user']], function () {
        // Route::get('shopkeeper_user', function () {
        //  dd("Go Shoper!!");
        // });
    });
});
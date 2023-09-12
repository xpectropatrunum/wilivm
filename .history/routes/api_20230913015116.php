<?php

use App\Http\Controllers\User\WalletController;
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

Route::post('wallet/perfectmoney', [WalletController::class, 'api']);
Route::post('order/perfectmoney', [WalletController::class, 'api']);
Route::get('order/perfectmoney', [WalletController::class, 'api']);
Route::get('order/coinpayments', [WalletController::class, 'cpIPN']);
Route::post('order/coinpayments', [WalletController::class, 'cpIPN']);
Route::post('wallet/coinpayments', [WalletController::class, 'cpIPNWallet']);
Route::post('bot/send', [WalletController::class, 'botSend']);

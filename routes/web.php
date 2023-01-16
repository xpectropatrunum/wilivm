<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Mail\OrderShipped;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    // Admin::create(["username" => "admin", "password" => Hash::make("123")]);
});
Route::get('/order-submition/{order}', function (Order $order) {
    Mail::to($order->email)->send(new OrderShipped($order));

});
Route::prefix("admin")->name("admin.")->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name("login");
    Route::post('logout', [LoginController::class, 'logout'])->name("logout");
    Route::post('login/attemp', [LoginController::class, 'loginAttemp'])->name("login.attemp");
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name("dashboard");
        Route::resource('users', UserController::class);
        Route::resource('orders', OrderController::class);
        Route::post('sendmail/{order}', [OrderController::class, "sendMail"])->name("sendmail");
 
    });


});
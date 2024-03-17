<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('products');
});

Route::get('/login',[AuthController::class,'login'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products');

    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('orders/{invoice}',[OrderController::class,'show'])->name('showOrder');

    Route::get('payments/{transaction_id}',[PaymentController::class,'show'])->name('showPayment');

    Route::get('cart', function () {
        return view('pages.member.cart');
    })->name('cart');
});

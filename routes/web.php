<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/transactions', [FrontController::class, 'transactions'])->name('front.transactions');
Route::post('/transactions/details', [FrontController::class, 'transaction_details'])->name('front.transaction.details');
Route::get('/search', [FrontController::class, 'search'])->name('front.search');
Route::get('/store/details/{store:slug}', [FrontController::class, 'details'])->name('front.details');
Route::post('/booking/payment/submit', [FrontController::class, 'booking_payment_store'])->name('front.booking.payment.store');
Route::get('/booking/{store:slug}', [FrontController::class, 'booking'])->name('front.booking');
Route::post('/booking/{store:slug}/{service:slug}', [FrontController::class, 'booking_store'])->name('front.booking.store');
Route::get('/booking/{store}/{service}/payment', [FrontController::class, 'booking_payment'])->name('front.booking.payment');
Route::get('/booking/success/{bookingTransaction}', [FrontController::class, 'success_booking'])->name('front.success.booking');

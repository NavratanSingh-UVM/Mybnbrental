<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    Route::controller(DashboardController::class)->group(function() {
        Route::get('/dashboard','dashboard')->name('dashboard');
        Route::get('/booking','booking')->name('booking');
        Route::get('booking-details/{id}','bookingDetails')->name('booking.details');
        Route::get('pay-remanining-balance/{id}','payRemainingBalance')->name('pay.remaining.balance');
        Route::post("make-remaining-paymnet",'makeReminingPayment')->name('make.remaining.payment');
        Route::get('/booking-transaction-histories','bookingTransactionHistories')->name('booking.transaction.histories');
        Route::get('/switch-to-host','switchToHost')->name('switch.to.host');
        Route::get('edit-profile','editProfile')->name('edit.profile');
        Route::post('store-profile','updateProfile')->name('store.profile');
    });
});
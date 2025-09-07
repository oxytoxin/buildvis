<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BudgetEstimateController;
use App\Http\Controllers\StripeController;
use App\Http\Middleware\CheckIfHasValidShippingInfoMiddleware;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', Welcome::class)->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('register', Register::class)
        ->name('register');
    Route::get('login', Login::class)
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    // Budget Estimate API routes
    Route::post('/api/budget-estimates', [BudgetEstimateController::class, 'store']);
    Route::get('/api/budget-estimates/{id}', [BudgetEstimateController::class, 'show']);

    Route::group(['middleware' => ['auth', CheckIfHasValidShippingInfoMiddleware::class]], function () {
        Route::get('/stripe-checkout/{order}', [StripeController::class, 'checkout'])->name('stripe.checkout');
        Route::get('/stripe-cancel/{order}', [StripeController::class, 'cancel'])->name('stripe.cancel');
        Route::get('/stripe-success/{order}', [StripeController::class, 'success'])->name('stripe.success');

    });

    // Cart routes
    Route::redirect('/store', '/shop')->name('store.index');
});

<?php

use App\Livewire\Login;
use Livewire\Volt\Volt;
use App\Livewire\Profile;
use App\Livewire\Welcome;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\Product;
use Inertia\Inertia;

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

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::get('product/{product}', function (Product $product) {
        return Inertia::render('ProductView', [
            'product' => $product,
            'model' => $product->getFirstMedia('model')
        ]);
    })
        ->name('product.view');
});

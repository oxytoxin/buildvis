<?php

use App\Livewire\Login;
use Livewire\Volt\Volt;
use App\Livewire\Profile;
use App\Livewire\Welcome;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\StripeController;
use App\Models\Product;
use Inertia\Inertia;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;

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

    Route::get('product/{product}', function (Product $product) {
        return Inertia::render('ProductView', [
            'product' => $product->load(['variations.featured_image', 'variations.images']),
            'model' => $product->getFirstMedia('model')
        ]);
    })
        ->name('product.view');

    Route::get('house-generator', function (Product $product) {
        return Inertia::render('HouseGenerator', []);
    })
        ->name('house-generator.view');

    Route::get('/stripe-checkout/{order}', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe-cancel/{order}', [StripeController::class, 'cancel'])->name('stripe.cancel');
    Route::get('/stripe-success/{order}', [StripeController::class, 'success'])->name('stripe.success');

    // Cart routes
    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('cart.add');
    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
});

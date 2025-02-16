<?php

use App\Livewire\Profile;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', Profile::class)
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

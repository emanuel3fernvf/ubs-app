<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard')
    ->group(function () {
        Route::view('/', 'dashboard');

        Route::view('/newp', 'dashboard-newp')
            ->name('.newp');

        Route::view('/patient', 'patient')
            ->name('.patient');
    });

Route::view('perfil', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard')
    ->group(function () {
        Route::view('/', 'dashboard');

        Route::view('/paciente', 'patient')
            ->name('.patient');
    });

Route::view('perfil', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

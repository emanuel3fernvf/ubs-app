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

        Route::view('/especialidade', 'specialty')
            ->name('.specialty');

        Route::view('/profissional', 'professional')
            ->name('.professional');

        Route::view('/endereco', 'address')
            ->name('.address');

        Route::view('/unidade', 'unit')
            ->name('.unit');

        Route::view('/agendamento', 'schedule')
            ->name('.schedule');

        Route::view('/usuario', 'user')
            ->name('.user');
    });

Route::view('perfil', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

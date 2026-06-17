<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/dashboard', function () {

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    if ($user->role === 'penjual') {
        return redirect('/penjual/dashboard');
    }

    return redirect('/pembeli/dashboard');

})->middleware(['auth'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::view(
            '/admin/dashboard',
            'admin.dashboard'
        )->name('admin.dashboard');

    });

/*
|--------------------------------------------------------------------------
| PENJUAL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:penjual'])
    ->group(function () {

        Route::view(
            '/penjual/dashboard',
            'penjual.dashboard'
        )->name('penjual.dashboard');

    });

/*
|--------------------------------------------------------------------------
| PEMBELI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pembeli'])
    ->group(function () {

        Route::view(
            '/pembeli/dashboard',
            'pembeli.dashboard'
        )->name('pembeli.dashboard');

    });

require __DIR__.'/auth.php';
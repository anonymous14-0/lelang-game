<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Penjual\ItemController;
use App\Http\Controllers\Pembeli\BidController;
use App\Http\Controllers\Pembeli\AuctionController as PembeliAuctionController;
use App\Http\Controllers\Penjual\AuctionController as PenjualAuctionController;

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
        Route::resource(
            '/admin/categories',
            CategoryController::class
        )->names('admin.categories');


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

        Route::resource(
            '/penjual/items',
            ItemController::class
        )->names('penjual.items');
        Route::resource(
            '/penjual/auctions',
            PenjualAuctionController::class
        )->names('penjual.auctions');
        
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
        Route::get(
            '/pembeli/auctions',
            [PembeliAuctionController::class, 'index']
        )->name('pembeli.auctions.index');
        Route::post(
            '/auctions/{auction}/bid',
            [BidController::class, 'store']
        )->name('bids.store');
        Route::get(
            '/pembeli/auctions/{auction}',
            [PembeliAuctionController::class, 'show']
        )->name('pembeli.auctions.show');
    });

require __DIR__.'/auth.php';
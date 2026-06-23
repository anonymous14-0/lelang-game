<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Penjual\ItemController;
use App\Http\Controllers\Pembeli\BidController;
use App\Http\Controllers\Pembeli\AuctionController as PembeliAuctionController;
use App\Http\Controllers\Penjual\AuctionController as PenjualAuctionController;
use App\Http\Controllers\Pembeli\DashboardController;
use App\Http\Controllers\Pembeli\TransactionController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Penjual\TransactionController as PenjualTransactionController;
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Halaman utama aplikasi.
Route::view('/', 'welcome');

// Redirect dashboard umum ke dashboard sesuai role pengguna.
Route::get('/dashboard', function () {

    // Ambil user yang sedang login untuk menentukan tujuan dashboard.
    $user = Auth::user();

    // Admin diarahkan ke dashboard khusus admin.
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    // Penjual diarahkan ke dashboard khusus penjual.
    if ($user->role === 'penjual') {
        return redirect('/penjual/dashboard');
    }

    // Role pembeli diarahkan ke dashboard pembeli.
    return redirect('/pembeli/dashboard');

})->middleware(['auth'])->name('dashboard');

// Halaman profil hanya tersedia untuk pengguna yang sudah login.
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

// Kumpulan route admin yang dilindungi autentikasi dan role admin.
Route::middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get(
            '/admin/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('admin.dashboard');
        Route::resource(
            '/admin/categories',
            CategoryController::class
        )->names('admin.categories');
        Route::get(
            '/admin/transactions',
            [AdminTransactionController::class, 'index']
        )->name('admin.transactions.index');

        Route::post(
            '/admin/transactions/{transaction}/verify',
            [AdminTransactionController::class, 'verify']
        )->name('admin.transactions.verify');

        Route::post(
            '/admin/transactions/{transaction}/reject',
            [AdminTransactionController::class, 'reject']
        )->name('admin.transactions.reject');
    });


/*
|--------------------------------------------------------------------------
| PENJUAL
|--------------------------------------------------------------------------
*/

// Kumpulan route penjual yang dilindungi autentikasi dan role penjual.
Route::middleware(['auth', 'role:penjual'])
    ->group(function () {

        Route::get(
            '/penjual/dashboard',
            [PenjualDashboardController::class, 'index']
        )->name('penjual.dashboard');

        Route::resource(
            '/penjual/items',
            ItemController::class
        )->names('penjual.items');
        Route::resource(
            '/penjual/auctions',
            PenjualAuctionController::class
        )->names('penjual.auctions');
        Route::get(
            '/penjual/transactions',
            [PenjualTransactionController::class, 'index']
        )->name('penjual.transactions.index');

        Route::post(
            '/penjual/transactions/{transaction}/send-account',
            [PenjualTransactionController::class, 'sendAccount']
        )->name('penjual.transactions.send');
        
    });

/*
|--------------------------------------------------------------------------
| PEMBELI
|--------------------------------------------------------------------------
*/

// Kumpulan route pembeli yang dilindungi autentikasi dan role pembeli.
Route::middleware(['auth', 'role:pembeli'])
    ->group(function () {

        Route::get(
            '/pembeli/dashboard',
            [DashboardController::class, 'index']
        )->name('pembeli.dashboard');
        Route::get(
            '/pembeli/auctions',
            [PembeliAuctionController::class, 'index']
        )->name('pembeli.auctions.index');
        // Route untuk mengirim bid pada lelang tertentu.
        Route::post(
            '/auctions/{auction}/bid',
            [BidController::class, 'store']
        )->name('bids.store');
        Route::get(
            '/pembeli/auctions/{auction}',
            [PembeliAuctionController::class, 'show']
        )->name('pembeli.auctions.show');
        Route::get(
            '/pembeli/transactions',
            [TransactionController::class, 'index']
        )->name('pembeli.transactions.index');

        Route::post(
            '/pembeli/transactions/{transaction}/upload-proof',
            [TransactionController::class, 'uploadProof']
        )->name('pembeli.transactions.upload');
        Route::get(
            '/pembeli/transactions/{transaction}',
            [TransactionController::class, 'show']
        )->name('pembeli.transactions.show');

        Route::post(
            '/pembeli/transactions/{transaction}/complete',
            [TransactionController::class, 'complete']
        )->name('pembeli.transactions.complete');
    });

require __DIR__.'/auth.php';
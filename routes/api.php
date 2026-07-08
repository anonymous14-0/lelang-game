<?php

/*
|--------------------------------------------------------------------------
| routes/api.php
|--------------------------------------------------------------------------
|
| File ini mendefinisikan seluruh endpoint REST API GameBid yang dikonsumsi
| oleh aplikasi Android Kotlin Jetpack Compose. Route bertugas sebagai pintu
| masuk request sebelum diteruskan ke Controller, Model Eloquent, dan database
| MySQL. Endpoint publik dapat diakses tanpa token, sedangkan endpoint privat
| dilindungi Laravel Sanctum agar hanya user login yang dapat mengakses data.
|
| Alur arsitektur API:
| Android App -> Route -> Controller -> Eloquent Model -> MySQL -> JSON Response
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuctionController;
use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\CategoryController;

// Endpoint health check sederhana untuk memastikan API Laravel dapat diakses
// dari browser, Postman, atau aplikasi Android selama proses development.
Route::get('/test', function () {
    return response()->json([
        // Pesan ringkas yang menunjukkan service API sedang berjalan.
        'message' => 'API jalan'
    ]);
});

// =============================
// AUTHENTICATION API
// Tidak memerlukan login karena dipakai untuk membuat atau memperoleh token.
// Sanctum token yang dihasilkan dipakai Android pada header Authorization.
// =============================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// =============================
// PUBLIC API
// Boleh diakses tanpa login agar halaman Home dan Detail Auction pada Android
// dapat menampilkan daftar lelang aktif sebelum user melakukan autentikasi.
// =============================
Route::get('/auctions', [AuctionController::class, 'index']);
Route::get('/auctions/{auction}', [AuctionController::class, 'show']);


// =============================
// PRIVATE API
// Memerlukan middleware auth:sanctum. Middleware ini memvalidasi personal
// access token dari Android sehingga endpoint transaksi, bidding, item seller,
// dan profil hanya bisa digunakan oleh user yang sudah login.
// =============================
Route::middleware('auth:sanctum')->group(function () {
    // Mengembalikan data user login berdasarkan token Sanctum yang valid.
    Route::get('/user', [AuthController::class, 'user']);

    // Menghapus token login agar Android tidak dapat memakai token lama lagi.
    Route::post('/logout', [AuthController::class, 'logout']);

    // Endpoint bidding: pembeli mengirim nominal bid untuk auction tertentu.
    Route::post(
        '/auctions/{auction}/bid',
        [BidController::class, 'store']
    );

    // Endpoint transaksi: pembeli melihat pembeliannya, penjual melihat transaksi item miliknya.
    Route::get(
        '/transactions',
        [TransactionController::class, 'index']
    );

    // Endpoint detail transaksi untuk menampilkan status pembayaran dan pengiriman akun game.
    Route::get(
        '/transactions/{transaction}',
        [TransactionController::class, 'show']
    );

    // Endpoint upload bukti transfer dari pembeli sebagai bagian dari proses escrow.
    Route::post(
        '/transactions/{transaction}/upload-proof',
        [TransactionController::class, 'uploadProof']
    );

    // Endpoint penjual mengirim credential akun game setelah pembayaran diverifikasi.
    Route::post(
        '/transactions/{transaction}/send-account',
        [TransactionController::class, 'sendAccount']
    );

    // Endpoint pembeli menyelesaikan transaksi setelah akun game diterima.
    Route::post(
        '/transactions/{transaction}/complete',
        [TransactionController::class, 'complete']
    );

    // Endpoint dashboard seller pada Android untuk melihat auction miliknya.
    Route::get(
        '/seller/auctions',
        [AuctionController::class, 'sellerAuctions']
    );

    // Endpoint seller Android untuk membuat auction dari item draft yang dimiliki.
    Route::post(
        '/seller/auctions',
        [AuctionController::class, 'storeMobile']
    );

    // Endpoint seller Android untuk mengambil item draft yang belum memiliki auction.
    Route::get(
        '/seller/items',
        [AuctionController::class, 'sellerItems']
    );

    // Endpoint seller Android untuk menambahkan item game baru ke database.
    Route::post('/seller/items', [ItemController::class, 'store']);

    // Endpoint kategori agar form item di Android dapat menampilkan pilihan kategori.
    Route::get(
        '/seller/categories',
        [CategoryController::class, 'index']
    );

    // Endpoint profil ringkas yang mengambil user langsung dari request terautentikasi.
    Route::get('/profile', function (Request $request) {
        return response()->json([
            // Status boolean agar Android mudah membedakan request berhasil atau gagal.
            'status' => true,

            // Data user login dari token Sanctum; berasal dari tabel users.
            'data' => $request->user()
        ]);
    });
});

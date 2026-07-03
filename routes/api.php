<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuctionController;
use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\TransactionController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API jalan'
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// PUBLIC API (boleh diakses tanpa login)
Route::get('/auctions', [AuctionController::class, 'index']);
Route::get('/auctions/{auction}', [AuctionController::class, 'show']);


// PRIVATE API (harus login)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post(
        '/auctions/{auction}/bid',
        [BidController::class, 'store']
    );
    Route::get(
        '/transactions',
        [TransactionController::class, 'index']
    );

    Route::get(
        '/transactions/{transaction}',
        [TransactionController::class, 'show']
    );

    Route::post(
        '/transactions/{transaction}/upload-proof',
        [TransactionController::class, 'uploadProof']
    );

    Route::post(
        '/transactions/{transaction}/send-account',
        [TransactionController::class, 'sendAccount']
    );

    Route::post(
        '/transactions/{transaction}/complete',
        [TransactionController::class, 'complete']
    );
});
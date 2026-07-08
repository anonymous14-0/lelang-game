<?php

/*
|--------------------------------------------------------------------------
| BidController
|--------------------------------------------------------------------------
|
| Controller bidding GameBid. Menerima nominal bid dari Android, memvalidasi angka tawaran, menyimpan ke tabel bids, dan memperbarui current_price serta winner_id pada tabel auctions tanpa mengubah response API.
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    // POST /api/auctions/{auction}/bid
    //
    // Membuat bid baru untuk auction tertentu. Request berisi amount dari
    // Android. User wajib login karena user_id diambil dari token auth:sanctum.
    // Business logic utama: nominal bid harus lebih tinggi dari current_price.
    // Response sukses: message Bid berhasil. Response gagal: HTTP 422.
    public function store(Request $request, Auction $auction)
    {
        $request->validate([
            // Amount wajib angka agar perbandingan harga dan penyimpanan decimal aman.
            'amount' => 'required|numeric'
        ]);

        // Menolak bid yang tidak melampaui harga berjalan untuk menjaga aturan lelang.
        if ($request->amount <= $auction->current_price) {
            return response()->json([
                'message' => 'Bid harus lebih tinggi'
            ], 422);
        }

        // Menyimpan riwayat bid ke tabel bids sebagai audit trail penawaran.
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount
        ]);

        // Memperbarui harga berjalan dan kandidat pemenang terbaru pada auction.
        $auction->update([
            'current_price' => $request->amount,
            'winner_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Bid berhasil'
        ]);
    }
}
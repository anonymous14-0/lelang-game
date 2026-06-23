<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Auction;

// Controller untuk mengelola data lelang sesuai area pengguna.
class AuctionController extends Controller
{
    // Menampilkan data utama pada halaman index.
    public function index()
    {
        $auctions = Auction::with('item')
            ->where('status', 'active')
            ->latest()
            ->get();

        return view(
            'pembeli.auctions.index',
            compact('auctions')
        );
    }
    // Menampilkan detail lelang beserta item dan riwayat bid.
    public function show(Auction $auction)
    {
        // Load relasi yang dibutuhkan untuk halaman detail lelang.
        $auction->load([
            'item',
            'bids.user'
        ]);

        return view(
            'pembeli.auctions.show',
            compact('auction')
        );
    }
}
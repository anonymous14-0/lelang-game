<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Transaction;

// Controller untuk menampilkan ringkasan dashboard pengguna.
class DashboardController extends Controller
{
    // Menampilkan data utama pada halaman index.
    public function index()
    {
        $activeAuctions = Auction::where(
            'status',
            'active'
        )->count();

        $myBids = Bid::where(
            'user_id',
            auth()->id()
        )->count();

        $myTransactions = Transaction::where(
            'buyer_id',
            auth()->id()
        )->count();

        $wonAuctions = Auction::where(
            'winner_id',
            auth()->id()
        )->count();

        $latestBids = Bid::with('auction.item')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $activeAuctionList = Auction::with('item')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        return view(
            'pembeli.dashboard',
            compact(
                'activeAuctionList',
                'activeAuctions',
                'myBids',
                'myTransactions',
                'wonAuctions',
                'latestBids'
            )
        );
    }
}
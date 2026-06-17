<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Auction;

class AuctionController extends Controller
{
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
    public function show(Auction $auction)
    {
        return view(
            'pembeli.auctions.show',
            compact('auction')
        );
    }
}
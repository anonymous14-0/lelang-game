<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::with([
            'item',
            'item.category'
        ])
        ->where('status', 'active')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $auctions
        ]);
    }

    public function show(Auction $auction)
    {
        $auction->load([
            'item',
            'item.category',
            'bids.user',
            'winner'
        ]);

        return response()->json([
            'status' => true,
            'data' => $auction
        ]);
    }
}
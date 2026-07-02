<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        if ($request->amount <= $auction->current_price) {
            return response()->json([
                'message' => 'Bid harus lebih tinggi'
            ], 422);
        }

        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount
        ]);

        $auction->update([
            'current_price' => $request->amount,
            'winner_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Bid berhasil'
        ]);
    }
}
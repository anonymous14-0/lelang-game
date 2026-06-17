<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Auction;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        if ($request->amount <= $auction->current_price) {

            return back()->with(
                'error',
                'Tawaran harus lebih tinggi dari harga saat ini.'
            );
        }

        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        $auction->update([
            'current_price' => $request->amount,
        ]);

        return back()->with(
            'success',
            'Tawaran berhasil dikirim.'
        );
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;
use App\Models\Item;
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
    public function sellerAuctions(Request $request)
    {
        $sellerId = $request->user()->id;

        $auctions = \App\Models\Auction::with([
            'item',
            'item.category'
        ])
        ->whereHas('item', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })
        ->get();

        return response()->json([
            'status' => true,
            'data' => $auctions
        ]);
    }
    public function storeMobile(Request $request)
    {
        \Log::info('STORE MOBILE KEHIT');
        \Log::info($request->all());

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $item = Item::find($request->item_id);

        \Log::info('ITEM DITEMUKAN', [
            'item' => $item
        ]);

        $auction = Auction::create([
            'item_id' => $request->item_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'starting_price' => $item->starting_price,
            'current_price' => $item->starting_price,
            'status' => 'active'
        ]);

        \Log::info('AUCTION CREATED', [
            'auction' => $auction
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Auction berhasil dibuat',
            'data' => $auction
        ]);
    }
    public function sellerItems(Request $request)
    {
        $items = Item::where(
                'user_id',
                $request->user()->id
            )
            ->where('status', 'draft')
            ->whereDoesntHave('auction')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }
}
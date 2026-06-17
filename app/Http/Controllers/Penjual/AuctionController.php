<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Item;
class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auctions = Auction::with('item')
            ->whereHas('item', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view(
            'penjual.auctions.index',
            compact('auctions')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::where(
            'user_id',
            auth()->id()
        )->doesntHave('auction')->get();

        return view(
            'penjual.auctions.create',
            compact('items')
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $item = Item::findOrFail(
            $request->item_id
        );

        Auction::create([
            'item_id' => $item->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'starting_price' => $item->starting_price,
            'current_price' => $item->starting_price,
            'status' => 'active',
        ]);

        return redirect()
            ->route('penjual.auctions.index')
            ->with('success', 'Lelang berhasil dibuat');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

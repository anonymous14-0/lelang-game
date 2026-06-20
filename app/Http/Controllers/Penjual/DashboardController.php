<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Auction;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalItems = Item::where(
            'user_id',
            $userId
        )->count();

        $activeAuctions = Auction::whereHas(
            'item',
            function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        )->where('status', 'active')->count();

        $totalTransactions = Transaction::whereHas(
            'auction.item',
            function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        )->count();

        return view(
            'penjual.dashboard',
            compact(
                'totalItems',
                'activeAuctions',
                'totalTransactions'
            )
        );
    }
}
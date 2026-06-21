<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Auction;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalItems' => Item::count(),
            'activeAuctions' => Auction::where('status', 'active')->count(),
            'totalTransactions' => Transaction::count(),
        ]);
    }
}
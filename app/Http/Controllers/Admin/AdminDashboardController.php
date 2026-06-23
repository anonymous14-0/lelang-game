<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Auction;
use App\Models\Transaction;

// Controller untuk menampilkan ringkasan data utama pada dashboard admin.
class AdminDashboardController extends Controller
{
    // Mengambil statistik keseluruhan untuk ditampilkan pada dashboard admin.
    // Menampilkan data utama pada halaman index.
    public function index()
    {
        // Menghitung total data penting dari database sebagai ringkasan sistem.
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalItems' => Item::count(),
            'activeAuctions' => Auction::where('status', 'active')->count(),
            'totalTransactions' => Transaction::count(),
        ]);
    }
}
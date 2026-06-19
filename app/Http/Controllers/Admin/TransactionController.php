<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with([
            'buyer',
            'auction.item'
        ])->latest()->get();

        return view(
            'admin.transactions.index',
            compact('transactions')
        );
    }

    public function verify(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'escrow'
        ]);

        return back()->with(
            'success',
            'Pembayaran berhasil diverifikasi'
        );
    }

    public function reject(
        Request $request,
        Transaction $transaction
    ) {
        $transaction->update([
            'status' => 'pending_payment',
            'admin_note' => $request->admin_note
        ]);

        return back()->with(
            'error',
            'Pembayaran ditolak'
        );
    }
}
<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with([
            'auction.item',
            'buyer'
        ])
        ->where('status', 'escrow')
        ->latest()
        ->get();

        return view(
            'penjual.transactions.index',
            compact('transactions')
        );
    }

    public function sendAccount(
        Request $request,
        Transaction $transaction
    ) {
        $request->validate([
            'account_email' => 'required',
            'account_password' => 'required',
        ]);

        $transaction->update([
            'account_email' => $request->account_email,

            'account_password' => Crypt::encryptString(
                $request->account_password
            ),

            'seller_note' => $request->seller_note,

            'status' => 'account_sent'
        ]);

        return back()->with(
            'success',
            'Akun berhasil dikirim'
        );
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with([
            'auction.item'
        ])
        ->where('buyer_id', $request->user()->id)
        ->get();

        return response()->json([
            'status' => true,
            'data' => $transactions
        ]);
    }

    public function show(Transaction $transaction)
    {
        $transaction->load([
            'auction.item',
            'buyer'
        ]);

        return response()->json([
            'status' => true,
            'data' => $transaction
        ]);
    }
    public function uploadProof(
        Request $request,
        Transaction $transaction
    ) {
        $request->validate([
            'payment_proof' => 'required|image'
        ]);

        $path = $request
            ->file('payment_proof')
            ->store('payment_proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status' => 'payment_verified'
        ]);

        return response()->json([
            'message' => 'Bukti transfer berhasil upload'
        ]);
    }
    public function sendAccount(
        Request $request,
        Transaction $transaction
    ) {
        $request->validate([
            'account_email' => 'required',
            'account_password' => 'required'
        ]);

        $transaction->update([
            'account_email' => $request->account_email,
            'account_password' => $request->account_password,
            'seller_note' => $request->seller_note,
            'status' => 'account_sent'
        ]);

        return response()->json([
            'message' => 'Akun berhasil dikirim'
        ]);
    }
    public function complete(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'completed'
        ]);

        return response()->json([
            'message' => 'Transaksi selesai'
        ]);
    }
}
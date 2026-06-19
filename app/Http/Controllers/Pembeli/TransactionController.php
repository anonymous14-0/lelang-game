<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('auction.item')
            ->where('buyer_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'pembeli.transactions.index',
            compact('transactions')
        );
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
            ->store('payments', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status' => 'payment_verified'
        ]);

        return back()->with(
            'success',
            'Bukti transfer berhasil diupload'
        );
    }
    public function show(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load('auction.item');

        $password = null;

        if ($transaction->account_password) {
            $password = Crypt::decryptString(
                $transaction->account_password
            );
        }

        return view(
            'pembeli.transactions.show',
            compact('transaction', 'password')
        );
    }

    public function complete(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403);
        }

        if ($transaction->status !== 'account_sent') {
            return back()->with(
                'error',
                'Akun belum dikirim penjual'
            );
        }

        $transaction->update([
            'status' => 'completed'
        ]);

        return back()->with(
            'success',
            'Transaksi selesai'
        );
    }
}
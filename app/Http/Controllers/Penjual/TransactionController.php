<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

// Controller untuk mengelola daftar dan status transaksi.
class TransactionController extends Controller
{
    // Menampilkan data utama pada halaman index.
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

    // Mengirim data akun kepada pembeli setelah pembayaran masuk escrow.
    public function sendAccount(
        Request $request,
        Transaction $transaction
    ) {
        // Validasi data akun sebelum dikirim ke pembeli.
        $request->validate([
            'account_email' => 'required',
            'account_password' => 'required',
        ]);

        $transaction->update([
            'account_email' => $request->account_email,

            // Enkripsi password akun sebelum disimpan.
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
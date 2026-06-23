<?php

namespace App\Http\Controllers\Pembeli;

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
        $transactions = Transaction::with('auction.item')
            ->where('buyer_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'pembeli.transactions.index',
            compact('transactions')
        );
    }

    // Mengupload bukti pembayaran transaksi pembeli.
    public function uploadProof(
        Request $request,
        Transaction $transaction
    ) {
        // Validasi bukti pembayaran harus berupa gambar.
        $request->validate([
            'payment_proof' => 'required|image'
        ]);

        // Simpan file bukti pembayaran ke storage public.
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

    // Menandai transaksi selesai setelah akun diterima pembeli.
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
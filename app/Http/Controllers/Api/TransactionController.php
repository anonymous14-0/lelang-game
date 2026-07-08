<?php

/*
|--------------------------------------------------------------------------
| TransactionController
|--------------------------------------------------------------------------
|
| Controller transaksi GameBid. Mengelola daftar transaksi, detail transaksi, upload bukti transfer, pengiriman akun game, dan penyelesaian transaksi. Data berasal dari tabel transactions, auctions, items, dan users.
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // GET /api/transactions
    //
    // Mengambil transaksi sesuai role user. Pembeli melihat transaksi miliknya,
    // sedangkan penjual melihat transaksi dari item yang ia jual. Akses private
    // auth:sanctum. Response: status dan data transaksi beserta auction.item.
    public function index(Request $request)
    {
        $user = $request->user();

        // Branch pembeli: filter langsung berdasarkan buyer_id pada tabel transactions.
        if ($user->role === 'pembeli') {
            $transactions = Transaction::with([
                'auction.item'
            ])
            ->where('buyer_id', $user->id)
            ->get();
        } else {
            // Branch seller/admin: filter melalui relasi auction.item agar data sesuai pemilik item.
            $transactions = Transaction::with([
                'auction.item'
            ])
            ->whereHas('auction.item', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
        }

        return response()->json([
            'status' => true,
            'data' => $transactions
        ]);
    }

    // GET /api/transactions/{transaction}
    //
    // Menampilkan detail transaksi, item lelang, dan buyer untuk halaman detail
    // transaksi Android. Akses private auth:sanctum. Response: status dan data.
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
    // POST /api/transactions/{transaction}/upload-proof
    //
    // Menerima upload bukti transfer dari pembeli. File wajib image untuk
    // mengurangi risiko upload file berbahaya. Path disimpan di database dan
    // status transaksi berubah menjadi payment_verified sesuai flow escrow.
    // Akses private auth:sanctum. Response: message.
    public function uploadProof(
        Request $request,
        Transaction $transaction
    ) {
        $request->validate([
            // Bukti pembayaran wajib berupa gambar agar dapat diverifikasi admin/seller.
            'payment_proof' => 'required|image'
        ]);

        // File disimpan pada disk public agar path dapat diakses oleh aplikasi sesuai konfigurasi storage.
        $path = $request
            ->file('payment_proof')
            ->store('payment_proofs', 'public');

        // Update status menandai pembayaran telah diterima untuk proses berikutnya.
        $transaction->update([
            'payment_proof' => $path,
            'status' => 'payment_verified'
        ]);

        return response()->json([
            'message' => 'Bukti transfer berhasil upload'
        ]);
    }
    // POST /api/transactions/{transaction}/send-account
    //
    // Digunakan penjual untuk mengirim email/password akun game kepada pembeli
    // setelah pembayaran diverifikasi. Status transaksi berubah menjadi
    // account_sent agar Android mengetahui akun sudah dikirim.
    public function sendAccount(
        Request $request,
        Transaction $transaction
    ) {
        $request->validate([
            // Email akun game wajib diisi agar pembeli dapat login ke akun yang dibeli.
            'account_email' => 'required',

            // Password akun game wajib dikirim sebagai credential utama transaksi.
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
    // POST /api/transactions/{transaction}/complete
    //
    // Menandai transaksi selesai setelah pembeli menerima akun game. Status
    // completed menjadi akhir normal dari flow escrow GameBid.
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
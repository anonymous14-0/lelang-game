<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Auction;

// Controller untuk memproses bid dari pembeli pada lelang aktif.
class BidController extends Controller
{
    // Menyimpan bid baru dan memperbarui harga lelang saat bid valid.
    public function store(Request $request, Auction $auction)
    {
        // Validasi nominal bid yang dikirim pembeli.
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Tolak bid jika nominal tidak lebih tinggi dari harga saat ini.
        if ($request->amount <= $auction->current_price) {

            return back()->with(
                'error',
                'Tawaran harus lebih tinggi dari harga saat ini.'
            );
        }

        // Simpan bid pembeli ke database.
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        // Perbarui harga terkini lelang sesuai bid terbaru.
        $auction->update([
            'current_price' => $request->amount,
        ]);

        return back()->with(
            'success',
            'Tawaran berhasil dikirim.'
        );
    }
}
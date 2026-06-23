<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Transaction;

// Command untuk mengecek lelang yang sudah selesai dan menentukan pemenangnya.
class CheckAuctionWinners extends Command
{
    protected $signature = 'auction:check-winners';

    protected $description = 'Check auctions that have ended and determine winners';

    // Menjalankan proses penentuan pemenang untuk setiap lelang yang telah berakhir.
    public function handle()
    {
        // Ambil semua lelang aktif yang waktu berakhirnya sudah lewat.
        $endedAuctions = Auction::where('status', 'active')
            ->where('end_time', '<=', now())
            ->get();

        // Proses setiap lelang untuk mencari tawaran tertinggi.
        foreach ($endedAuctions as $auction) {

            // Cari bid terbesar sebagai calon pemenang lelang.
            $highestBid = $auction->bids()
                ->orderByDesc('amount')
                ->first();

            // Jika tidak ada bid, cukup tandai lelang sebagai selesai.
            if (!$highestBid) {
                $auction->update([
                    'status' => 'ended'
                ]);
                continue;
            }

            // Simpan pemenang dan harga akhir lelang.
            $auction->update([
                'winner_id' => $highestBid->user_id,
                'current_price' => $highestBid->amount,
                'status' => 'ended'
            ]);

            // Buat transaksi pembayaran untuk pemenang lelang.
            Transaction::create([
                'auction_id' => $auction->id,
                'buyer_id' => $highestBid->user_id,
                'amount' => $highestBid->amount,
                'status' => 'pending_payment'
            ]);
        }

        $this->info('Auction check completed.');
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Transaction;

class CheckAuctionWinners extends Command
{
    protected $signature = 'auction:check-winners';

    protected $description = 'Check auctions that have ended and determine winners';

    public function handle()
    {
        $endedAuctions = Auction::where('status', 'active')
            ->where('end_time', '<=', now())
            ->get();

        foreach ($endedAuctions as $auction) {

            $highestBid = $auction->bids()
                ->orderByDesc('amount')
                ->first();

            if (!$highestBid) {
                $auction->update([
                    'status' => 'ended'
                ]);
                continue;
            }

            $auction->update([
                'winner_id' => $highestBid->user_id,
                'current_price' => $highestBid->amount,
                'status' => 'ended'
            ]);

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
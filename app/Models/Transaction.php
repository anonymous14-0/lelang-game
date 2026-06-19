<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'auction_id',
        'buyer_id',
        'amount',
        'status',
        'payment_proof',
        'admin_note',
        'account_email',
        'account_password',
        'seller_note',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
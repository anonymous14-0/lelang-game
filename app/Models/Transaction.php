<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model transaksi untuk proses pembayaran dan pengiriman akun pemenang lelang.
class Transaction extends Model
{
    // Kolom transaksi yang dapat diisi secara mass assignment.
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

    // Relasi transaksi ke lelang yang dimenangkan.
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    // Relasi transaksi ke user pembeli.
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
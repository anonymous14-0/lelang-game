<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk menyimpan tawaran pembeli pada sebuah lelang.
class Bid extends Model
{
    // Kolom yang boleh diisi saat membuat bid.
    protected $fillable = [
        'auction_id',
        'user_id',
        'amount',
    ];

    // Relasi bid ke lelang terkait.
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    // Relasi bid ke user yang memberi tawaran.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
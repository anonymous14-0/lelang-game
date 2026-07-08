<?php

/*
|--------------------------------------------------------------------------
| Auction Model
|--------------------------------------------------------------------------
|
| Model Auction merepresentasikan tabel auctions yang menyimpan jadwal lelang, harga awal, harga berjalan, pemenang, dan status. Relasi: belongsTo Item, hasMany Bid, belongsTo User sebagai winner. Android menerima model ini melalui endpoint auction dalam format JSON.
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk data lelang dan relasinya dengan item, bid, serta pemenang.
class Auction extends Model
{
    // Kolom yang boleh diisi secara mass assignment.
    protected $fillable = [
        'item_id',
        'start_time',
        'end_time',
        'starting_price',
        'current_price',
        'winner_id',
        'status',
    ];
    // Konversi otomatis kolom waktu menjadi objek datetime.
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];


    // Relasi ke item yang dilelang.
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke seluruh bid yang masuk pada lelang ini.
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // Relasi ke user pemenang lelang.
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model item yang akan dijual atau dilelang oleh penjual.
class Item extends Model
{
    // Kolom item yang boleh diisi secara mass assignment.
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'starting_price',
        'image',
        'status',
    ];

    // Relasi item ke user penjual.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi item ke kategori.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi item ke satu data lelang.
    public function auction()
    {
        return $this->hasOne(Auction::class);
    }
}
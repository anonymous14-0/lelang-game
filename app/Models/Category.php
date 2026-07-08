<?php

/*
|--------------------------------------------------------------------------
| Category Model
|--------------------------------------------------------------------------
|
| Model Category merepresentasikan tabel categories untuk pengelompokan item game. Relasi: hasMany Item. Android memakai data kategori saat seller membuat item.
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

// Model kategori untuk mengelompokkan item lelang.
class Category extends Model
{
    // Kolom kategori yang dapat diisi melalui mass assignment.
    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi kategori dengan banyak item.
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
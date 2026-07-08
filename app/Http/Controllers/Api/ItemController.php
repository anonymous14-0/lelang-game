<?php

/*
|--------------------------------------------------------------------------
| ItemController
|--------------------------------------------------------------------------
|
| Controller item seller. Digunakan aplikasi Android untuk membuat item game yang akan dilelang. Data disimpan ke tabel items, gambar opsional disimpan ke storage public, dan response dikirim sebagai JSON.
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // POST /api/seller/items
    //
    // Membuat item game baru dari Android seller. Data yang masuk divalidasi
    // sebelum disimpan ke tabel items. User pemilik item diambil dari token
    // Sanctum, bukan dari request body, untuk mencegah pemalsuan pemilik.
    // Akses: private auth:sanctum. Response: status, message, dan data item.
    public function store(Request $request)
    {
        $request->validate([
            // Category harus ada agar item selalu terhubung ke kategori valid.
            'category_id' => 'required|exists:categories,id',

            // Judul wajib untuk tampilan kartu item di Android.
            'title' => 'required',

            // Deskripsi wajib agar pembeli memahami detail akun game.
            'description' => 'required',

            // Harga awal wajib numeric karena dipakai sebagai starting_price auction.
            'starting_price' => 'required|numeric',

            // Gambar opsional tetapi jika ada harus image untuk keamanan upload file.
            'image' => 'nullable|image'
        ]);

        $imagePath = null;

        // Jika Android mengirim gambar item, simpan ke storage public dan simpan path-nya.
        if ($request->hasFile('image')) {
            $imagePath = $request
                ->file('image')
                ->store('items', 'public');
        }

        // Membuat item berstatus draft agar seller dapat membuat auction setelah item siap.
        $item = Item::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'image' => $imagePath,
            'status' => 'draft'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Item berhasil dibuat',
            'data' => $item
        ]);
    }
}
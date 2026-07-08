<?php

/*
|--------------------------------------------------------------------------
| CategoryController
|--------------------------------------------------------------------------
|
| Controller kategori. Menyediakan daftar kategori dari tabel categories agar Android dapat menampilkan pilihan kategori ketika seller membuat item.
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    // GET /api/seller/categories
    //
    // Mengambil seluruh kategori dari tabel categories untuk dropdown/picker
    // kategori di aplikasi Android. Akses berada dalam auth:sanctum pada route
    // seller sehingga hanya user login yang memakai endpoint ini.
    // Response: status dan data kategori.
    public function index()
    {
        return response()->json([
            // Menandakan request berhasil.
            'status' => true,
            // Seluruh data kategori yang tersimpan di database MySQL.
            'data' => Category::all()
        ]);
    }
}
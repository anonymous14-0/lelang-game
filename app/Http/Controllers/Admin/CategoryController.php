<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

// Controller untuk mengelola data kategori pada sisi admin.
class CategoryController extends Controller
{
    // Menampilkan daftar kategori terbaru.
    // Menampilkan data utama pada halaman index.
    public function index()
    {
        // Mengambil seluruh kategori dari database dengan urutan terbaru.
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan form tambah kategori.
    public function create()
    {
        return view('admin.categories.create');
    }

    // Menyimpan kategori baru dari input admin.
    public function store(Request $request)
    {
        // Validasi input sebelum kategori disimpan.
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        // Menyimpan data kategori baru ke database.
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // Menampilkan form edit untuk kategori terpilih.
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Memperbarui data kategori yang dipilih.
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        // Menyimpan perubahan kategori ke database.
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    // Menghapus kategori dari database.
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
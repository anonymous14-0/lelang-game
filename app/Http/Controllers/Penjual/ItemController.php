<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
// Controller untuk mengelola item milik penjual.
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan data utama pada halaman index.
    public function index()
    {
        $items = Item::where(
            'user_id',
            auth()->id()
        )->latest()->get();

        return view(
            'penjual.items.index',
            compact('items')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view(
            'penjual.items.create',
            compact('categories')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'starting_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request
                ->file('image')
                ->store('items', 'public');
        }

        Item::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'image' => $imagePath,
            'status' => 'draft',
        ]);

        return redirect()
            ->route('penjual.items.index')
            ->with('success', 'Item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

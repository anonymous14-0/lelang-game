<?php

/*
|--------------------------------------------------------------------------
| AuctionController
|--------------------------------------------------------------------------
|
| Controller ini menangani daftar lelang aktif, detail auction, dashboard
| seller, pembuatan auction dari mobile, dan pemilihan item seller. Data
| berasal dari tabel auctions, items, categories, bids, dan users melalui
| Eloquent ORM lalu dikirim sebagai JSON untuk Android Jetpack Compose.
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;
use App\Models\Item;
class AuctionController extends Controller
{
    // GET /api/auctions
    //
    // Mengambil seluruh auction aktif untuk halaman Home Android. Relasi item
    // dan category ikut dimuat agar client tidak perlu request tambahan.
    // Akses: public. Response: status dan data array auction.
    public function index()
    {
        // Eager loading relasi item dan category mencegah N+1 query pada list auction.
        $auctions = Auction::with([
            'item',
            'item.category'
        ])
        // Hanya auction berstatus active yang tampil pada katalog publik.
        ->where('status', 'active')
        ->get();

        return response()->json([
            // Status true menunjukkan request berhasil diproses.
            'status' => true,

            // Data auction yang siap dirender oleh Android.
            'data' => $auctions
        ]);
    }

    // GET /api/auctions/{auction}
    //
    // Menampilkan detail auction berdasarkan route model binding. Android
    // menggunakan response ini untuk detail item, riwayat bid, dan pemenang.
    // Akses: public. Response: status dan data auction lengkap.
    public function show(Auction $auction)
    {
        // Memuat relasi detail auction, bid beserta user, dan winner dalam satu response.
        $auction->load([
            'item',
            'item.category',
            'bids.user',
            'winner'
        ]);

        return response()->json([
            'status' => true,
            'data' => $auction
        ]);
    }
    // GET /api/seller/auctions
    //
    // Mengambil seluruh auction milik seller yang sedang login. Filter dilakukan
    // melalui relasi item.user_id agar seller hanya melihat lelang item miliknya.
    // Akses: private auth:sanctum. Response: status dan data auction seller.
    public function sellerAuctions(Request $request)
    {
        // ID seller berasal dari token Sanctum, bukan dari input user.
        $sellerId = $request->user()->id;

        $auctions = \App\Models\Auction::with([
            'item',
            'item.category'
        ])
        // whereHas memastikan auction dikembalikan hanya jika item dimiliki seller login.
        ->whereHas('item', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })
        ->get();

        return response()->json([
            'status' => true,
            'data' => $auctions
        ]);
    }
    // POST /api/seller/auctions
    //
    // Membuat auction baru dari aplikasi Android seller. Request berisi item_id,
    // start_time, dan end_time. Harga awal dan harga berjalan mengikuti data item.
    // Akses: private auth:sanctum. Response: status, message, dan data auction.
    public function storeMobile(Request $request)
    {
        \Log::info('STORE MOBILE KEHIT');
        \Log::info($request->all());

        $request->validate([
            // Item harus ada di database agar auction tidak merujuk item invalid.
            'item_id' => 'required|exists:items,id',

            // Waktu mulai wajib berupa date agar jadwal auction konsisten.
            'start_time' => 'required|date',

            // Waktu selesai harus setelah mulai agar durasi lelang valid.
            'end_time' => 'required|date|after:start_time',
        ]);

        // Mengambil item sebagai sumber starting_price untuk auction baru.
        $item = Item::find($request->item_id);

        \Log::info('ITEM DITEMUKAN', [
            'item' => $item
        ]);

        // Membuat auction aktif tanpa mengubah data item; current_price dimulai dari starting_price.
        $auction = Auction::create([
            'item_id' => $request->item_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'starting_price' => $item->starting_price,
            'current_price' => $item->starting_price,
            'status' => 'active'
        ]);

        \Log::info('AUCTION CREATED', [
            'auction' => $auction
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Auction berhasil dibuat',
            'data' => $auction
        ]);
    }
    // GET /api/seller/items
    //
    // Mengambil item draft milik seller yang belum memiliki auction. Endpoint
    // ini dipakai form Android saat seller memilih item yang akan dilelang.
    // Akses: private auth:sanctum. Response: status dan data item.
    public function sellerItems(Request $request)
    {
        // Query dibatasi ke item milik user login untuk menjaga authorization data seller.
        $items = Item::where(
                'user_id',
                $request->user()->id
            )
            // Hanya item draft yang boleh dipilih untuk dibuat auction baru.
            ->where('status', 'draft')
            // Mencegah satu item memiliki lebih dari satu auction.
            ->whereDoesntHave('auction')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }
}
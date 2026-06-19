<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Dashboard Pembeli
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="grid grid-cols-4 gap-4 mb-8">

            <div class="bg-blue-500 text-white p-4 rounded">
                <h3>Lelang Aktif</h3>
                <p class="text-2xl">{{ $activeAuctions }}</p>
            </div>

            <div class="bg-green-500 text-white p-4 rounded">
                <h3>Bid Saya</h3>
                <p class="text-2xl">{{ $myBids }}</p>
            </div>

            <div class="bg-yellow-500 text-white p-4 rounded">
                <h3>Transaksi</h3>
                <p class="text-2xl">{{ $myTransactions }}</p>
            </div>

            <div class="bg-purple-500 text-white p-4 rounded">
                <h3>Lelang Menang</h3>
                <p class="text-2xl">{{ $wonAuctions }}</p>
            </div>

        </div>
        <h3 class="text-xl mt-8 mb-4">
        Lelang Aktif
        </h3>

        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2">Item</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($activeAuctionList as $auction)
                    <tr>
                        <td class="border p-2">
                            {{ $auction->item->title }}
                        </td>

                        <td class="border p-2">
                            Rp {{ number_format($auction->current_price,0,',','.') }}
                        </td>

                        <td class="border p-2">
                            <a
                                href="{{ route('pembeli.auctions.show', $auction->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3 class="text-xl mb-4">Riwayat Bid Terbaru</h3>
    
        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2">Item</th>
                    <th class="border p-2">Bid</th>
                    <th class="border p-2">Waktu</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestBids as $bid)
                    <tr>
                        <td class="border p-2">
                            {{ $bid->auction->item->title }}
                        </td>
                        <td class="border p-2">
                            Rp {{ number_format($bid->amount,0,',','.') }}
                        </td>
                        <td class="border p-2">
                            {{ $bid->created_at->format('d-m-Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border p-2 text-center">
                            Belum ada riwayat bid
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    <a href="{{ route('pembeli.transactions.index') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">
        Buka Transactions
    </a>
    </div>
</x-app-layout>
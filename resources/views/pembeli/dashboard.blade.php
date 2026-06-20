<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Dashboard Pembeli
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- HERO --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg mb-8">
            <h1 class="text-3xl font-bold">
                Halo, {{ auth()->user()->name }} 👋
            </h1>

            <p class="mt-2 text-blue-100">
                Pantau auction, bid terbaru, dan transaksi kamu di sini.
            </p>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">

            <div class="bg-blue-500 rounded-xl shadow-lg p-5 text-white hover:scale-105 transition">
                <p class="text-sm">📦 Lelang Aktif</p>
                <p class="text-3xl font-bold mt-2">{{ $activeAuctions }}</p>
            </div>

            <div class="bg-green-500 rounded-xl shadow-lg p-5 text-white hover:scale-105 transition">
                <p class="text-sm">💰 Bid Saya</p>
                <p class="text-3xl font-bold mt-2">{{ $myBids }}</p>
            </div>

            <div class="bg-yellow-500 rounded-xl shadow-lg p-5 text-white hover:scale-105 transition">
                <p class="text-sm">🛒 Transaksi</p>
                <p class="text-3xl font-bold mt-2">{{ $myTransactions }}</p>
            </div>

            <div class="bg-purple-500 rounded-xl shadow-lg p-5 text-white hover:scale-105 transition">
                <p class="text-sm">🏆 Lelang Menang</p>
                <p class="text-3xl font-bold mt-2">{{ $wonAuctions }}</p>
            </div>
        </div>

        {{-- LELANG AKTIF --}}
        <h3 class="text-2xl font-bold mb-4 text-white">
            Lelang Aktif
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">

            @foreach($activeAuctionList as $auction)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 hover:shadow-2xl hover:-translate-y-1 transition">

                    @if($auction->item->image)
                        <img
                            src="{{ asset('storage/' . $auction->item->image) }}"
                            class="w-full h-44 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-44 bg-gray-300 rounded-lg flex items-center justify-center mb-4">
                            No Image
                        </div>
                    @endif

                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $auction->item->title }}
                    </h4>

                    <p class="text-green-500 font-bold text-xl mt-2">
                        Rp {{ number_format($auction->current_price,0,',','.') }}
                    </p>

                    <a
                        href="{{ route('pembeli.auctions.show', $auction->id) }}"
                        class="block text-center mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">

                        Detail
                    </a>
                </div>
            @endforeach
        </div>

        {{-- RIWAYAT BID --}}
        <h3 class="text-2xl font-bold mb-4 text-white">
            Riwayat Bid Terbaru
        </h3>

        <div class="space-y-4 mb-8">

            @forelse($latestBids as $bid)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-bold text-lg text-gray-900 dark:text-white">
                                {{ $bid->auction->item->title }}
                            </p>

                            <p class="text-green-500 font-semibold">
                                Bid: Rp {{ number_format($bid->amount,0,',','.') }}
                            </p>
                        </div>

                        <p class="text-sm text-gray-500">
                            {{ $bid->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                </div>
            @empty
                <div class="bg-gray-800 rounded-xl p-4 text-center">
                    Belum ada riwayat bid
                </div>
            @endforelse
        </div>

        {{-- QUICK ACTION --}}
        <div class="grid md:grid-cols-3 gap-4">
            <a
                href="{{ route('pembeli.auctions.index') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-xl text-center">

                Browse Lelang
            </a>

            <a
                href="{{ route('pembeli.transactions.index') }}"
                class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-xl text-center">

                Transactions
            </a>

            <a
                href="#"
                class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-xl text-center">

                Lelang Menang
            </a>
        </div>

    </div>
</x-app-layout>
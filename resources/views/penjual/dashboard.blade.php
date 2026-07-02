<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Dashboard Penjual
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- HERO --}}
        <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg mb-8">
            <h1 class="text-3xl font-bold">
                Halo, {{ auth()->user()->name }} 👋
            </h1>

            <p class="mt-2 text-purple-100">
                Kelola item game, lelang, dan transaksi penjualan kamu di sini.
            </p>
        </div>

        {{-- STATS DUMMY (nanti bisa pakai data database) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

            <div class="bg-blue-500 rounded-xl p-5 text-white shadow hover:scale-105 transition">
                <p class="text-sm">📦 Total Item</p>
                <h3 class="text-3xl font-bold">
                    {{ $totalItems }}
                </h3>
            </div>

            <div class="bg-green-500 rounded-xl p-5 text-white shadow hover:scale-105 transition">
                <p class="text-sm">🔥 Lelang Aktif</p>
                <h3 class="text-3xl font-bold">
                    {{ $activeAuctions }}
                </h3>
            </div>

            <div class="bg-yellow-500 rounded-xl p-5 text-white shadow hover:scale-105 transition">
                <p class="text-sm">💰 Transaksi</p>
                <h3 class="text-3xl font-bold">
                    {{ $totalTransactions }}
                </h3>
            </div>

        </div>

        {{-- QUICK ACTION --}}
        <h3 class="text-xl font-bold text-white mb-4">
            Quick Actions
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

            {{-- Tambah Item --}}
            <a
                href="{{ route('penjual.items.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white p-5 rounded-xl text-center shadow hover:scale-105 transition">

                <div class="text-2xl mb-2">➕</div>
                Tambah Item
            </a>

            {{-- Lihat Item --}}
            <a
                href="{{ route('penjual.items.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white p-5 rounded-xl text-center shadow hover:scale-105 transition">

                <div class="text-2xl mb-2">📦</div>
                Daftar Item
            </a>

            {{-- Buat Lelang --}}
            <a
                href="{{ route('penjual.auctions.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white p-5 rounded-xl text-center shadow hover:scale-105 transition">

                <div class="text-2xl mb-2">🔥</div>
                Buat Lelang
            </a>

            {{-- Lihat Auction --}}
            <a
                href="{{ route('penjual.auctions.index') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white p-5 rounded-xl text-center shadow hover:scale-105 transition">

                <div class="text-2xl mb-2">🏷️</div>
                Daftar Lelang
            </a>

            {{-- Transaksi --}}
            <a
                href="{{ route('penjual.transactions.index') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white p-5 rounded-xl text-center shadow hover:scale-105 transition">

                <div class="text-2xl mb-2">💰</div>
                Transaksi
            </a>

        </div>

        {{-- INFO BOX --}}
        <div class="mt-8 bg-gray-800 rounded-xl p-6 shadow">
            <h3 class="text-lg font-bold text-white mb-2">
                Tips Penjual
            </h3>

            <ul class="list-disc list-inside text-gray-300 space-y-1">
                <li>Upload gambar item yang jelas agar lebih menarik.</li>
                <li>Gunakan deskripsi item yang detail.</li>
                <li>Tentukan harga awal yang kompetitif.</li>
            </ul>
        </div>

    </div>
</x-app-layout>
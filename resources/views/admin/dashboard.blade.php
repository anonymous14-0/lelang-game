<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Welcome Banner --}}
        <div class="bg-gradient-to-r from-red-500 to-purple-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
            <h1 class="text-3xl font-bold">
                Halo, Administrator 👋
            </h1>
            <p class="mt-2 opacity-90">
                Kelola kategori, transaksi, dan aktivitas marketplace dari sini.
            </p>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            <div class="bg-blue-500 rounded-xl p-5 text-white shadow">
                <p class="text-sm">👥 Total User</p>
                <h3 class="text-3xl font-bold">{{ $totalUsers ?? 0 }}</h3>
            </div>

            <div class="bg-green-500 rounded-xl p-5 text-white shadow">
                <p class="text-sm">🎮 Total Item</p>
                <h3 class="text-3xl font-bold">{{ $totalItems ?? 0 }}</h3>
            </div>

            <div class="bg-yellow-500 rounded-xl p-5 text-white shadow">
                <p class="text-sm">🔥 Lelang Aktif</p>
                <h3 class="text-3xl font-bold">{{ $activeAuctions ?? 0 }}</h3>
            </div>

            <div class="bg-purple-500 rounded-xl p-5 text-white shadow">
                <p class="text-sm">💰 Transaksi</p>
                <h3 class="text-3xl font-bold">{{ $totalTransactions ?? 0 }}</h3>
            </div>
        </div>

        {{-- Quick Actions --}}
        <h3 class="text-xl font-semibold text-white mb-4">
            Quick Actions
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('admin.categories.index') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-xl text-center shadow">
                Kelola Kategori
            </a>

            <a href="{{ route('admin.transactions.index') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white p-4 rounded-xl text-center shadow">
                Kelola Transaksi
            </a>

            <a href="#"
               class="bg-red-500 hover:bg-red-600 text-white p-4 rounded-xl text-center shadow">
                Laporan Sistem
            </a>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                Aktivitas Terbaru
            </h3>

            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                <li>• User baru mendaftar</li>
                <li>• Item baru ditambahkan penjual</li>
                <li>• Pembayaran baru menunggu verifikasi</li>
            </ul>
        </div>

    </div>
</x-app-layout>
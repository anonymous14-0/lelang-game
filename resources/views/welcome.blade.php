<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameBid - Lelang Item Game</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white">

    {{-- Navbar --}}
    <nav class="border-b border-slate-800 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-400">
                🎮 GameBid
            </h1>

            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-purple-600 px-4 py-2 rounded-lg hover:bg-purple-700">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid md:grid-cols-2 gap-10 items-center">

            <div>
                <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                    Lelang Item Game
                    <span class="text-purple-400">Terpercaya</span>
                </h1>

                <p class="mt-6 text-gray-400 text-lg">
                    Jual beli skin, akun, dan item game favoritmu
                    dengan sistem lelang realtime yang aman.
                </p>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('register') }}"
                       class="bg-purple-600 px-6 py-3 rounded-xl hover:bg-purple-700">
                        Mulai Sekarang
                    </a>

                    <a href="{{ route('login') }}"
                       class="border border-slate-700 px-6 py-3 rounded-xl">
                        Login
                    </a>
                </div>
            </div>

            <div>
                <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e"
                     class="rounded-2xl shadow-2xl">
            </div>

        </div>
    </section>

    {{-- Stats --}}
    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            <div class="bg-slate-900 rounded-xl p-6">
                <h3 class="text-gray-400">User</h3>
                <p class="text-3xl font-bold text-blue-400">500+</p>
            </div>

            <div class="bg-slate-900 rounded-xl p-6">
                <h3 class="text-gray-400">Auction</h3>
                <p class="text-3xl font-bold text-green-400">120+</p>
            </div>

            <div class="bg-slate-900 rounded-xl p-6">
                <h3 class="text-gray-400">Bid</h3>
                <p class="text-3xl font-bold text-yellow-400">900+</p>
            </div>

            <div class="bg-slate-900 rounded-xl p-6">
                <h3 class="text-gray-400">Transaksi</h3>
                <p class="text-3xl font-bold text-purple-400">300+</p>
            </div>

        </div>
    </section>

    {{-- Auction Cards --}}
    <section class="max-w-7xl mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold mb-8">
            🔥 Trending Auction
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-slate-900 rounded-xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420"
                     class="w-full h-48 object-cover">
                <div class="p-5">
                    <h3 class="font-bold text-xl">Skin Legend ML</h3>
                    <p class="text-green-400 mt-2">Rp 500.000</p>
                    <button class="mt-4 w-full bg-blue-600 py-2 rounded">
                        Lihat Lelang
                    </button>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1493711662062-fa541adb3fc8"
                     class="w-full h-48 object-cover">
                <div class="p-5">
                    <h3 class="font-bold text-xl">Akun FF Sultan</h3>
                    <p class="text-green-400 mt-2">Rp 800.000</p>
                    <button class="mt-4 w-full bg-blue-600 py-2 rounded">
                        Lihat Lelang
                    </button>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1552820728-8b83bb6b773f"
                     class="w-full h-48 object-cover">
                <div class="p-5">
                    <h3 class="font-bold text-xl">Skin Valorant</h3>
                    <p class="text-green-400 mt-2">Rp 1.200.000</p>
                    <button class="mt-4 w-full bg-blue-600 py-2 rounded">
                        Lihat Lelang
                    </button>
                </div>
            </div>

        </div>
    </section>

    {{-- Features --}}
    <section class="max-w-7xl mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold mb-8">Kenapa GameBid?</h2>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-slate-900 p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-3">⚡ Realtime Bid</h3>
                <p class="text-gray-400">
                    Sistem bid cepat dan update otomatis.
                </p>
            </div>

            <div class="bg-slate-900 p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-3">🔒 Aman</h3>
                <p class="text-gray-400">
                    Transaksi diverifikasi admin.
                </p>
            </div>

            <div class="bg-slate-900 p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-3">🎯 Mudah</h3>
                <p class="text-gray-400">
                    UI sederhana dan user friendly.
                </p>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-slate-800 py-8 text-center text-gray-500">
        © {{ date('Y') }} GameBid - Web Lelang Item Game
    </footer>

</body>
</html>
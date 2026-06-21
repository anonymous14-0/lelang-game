<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            📦 Kirim Akun Game
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8 px-6">
        <div class="max-w-5xl mx-auto space-y-6">

            @foreach($transactions as $transaction)

                <div class="bg-slate-800 border border-slate-700 rounded-3xl shadow-xl p-6">

                    {{-- Header Card --}}
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-white">
                                {{ $transaction->auction->item->title }}
                            </h3>

                            <p class="text-gray-400 mt-1">
                                Buyer:
                                <span class="text-blue-400 font-semibold">
                                    {{ $transaction->buyer->name }}
                                </span>
                            </p>
                        </div>

                        <div class="bg-green-500/20 text-green-400 px-4 py-2 rounded-xl font-semibold">
                            Menunggu Pengiriman
                        </div>
                    </div>

                    {{-- Form --}}
                    <form
                        action="{{ route('penjual.transactions.send', $transaction->id) }}"
                        method="POST"
                        class="space-y-5"
                    >
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label class="block text-gray-300 mb-2 font-semibold">
                                Email Akun
                            </label>

                            <input
                                type="email"
                                name="account_email"
                                placeholder="Masukkan email akun game"
                                class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-gray-300 mb-2 font-semibold">
                                Password Akun
                            </label>

                            <input
                                type="text"
                                name="account_password"
                                placeholder="Masukkan password akun"
                                class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="block text-gray-300 mb-2 font-semibold">
                                Catatan Seller
                            </label>

                            <textarea
                                name="seller_note"
                                rows="4"
                                placeholder="Contoh: Setelah login segera ganti password..."
                                class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            ></textarea>
                        </div>

                        {{-- Warning --}}
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-2xl p-4">
                            <p class="text-yellow-300 text-sm">
                                ⚠ Pastikan email dan password benar sebelum dikirim.
                                Setelah akun dikirim, pembeli akan bisa melihat detail akun.
                            </p>
                        </div>

                        {{-- Button --}}
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 py-4 rounded-xl font-bold text-white text-lg hover:scale-[1.02] transition"
                        >
                            🚀 Kirim Akun
                        </button>

                    </form>
                </div>

            @endforeach

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            🔥 Buat Lelang
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8 px-6">
        <div class="max-w-4xl mx-auto">

            <div class="bg-slate-800 rounded-3xl shadow-2xl border border-slate-700 p-8">
                <form action="{{ route('penjual.auctions.store') }}"
                      method="POST"
                      class="space-y-6">
                    @csrf

                    {{-- Item --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Pilih Item
                        </label>

                        <select
                            name="item_id"
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        >
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->id }} - {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Tanggal Mulai
                        </label>

                        <input
                            type="datetime-local"
                            name="start_time"
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        >
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Tanggal Selesai
                        </label>

                        <input
                            type="datetime-local"
                            name="end_time"
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:outline-none"
                        >
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-slate-700 rounded-2xl p-4 border border-slate-600">
                        <p class="text-orange-400 font-semibold mb-2">
                            ⚡ Tips Lelang
                        </p>

                        <ul class="text-gray-300 text-sm space-y-1">
                            <li>• Pastikan item yang dipilih benar</li>
                            <li>• Tanggal selesai harus lebih besar dari tanggal mulai</li>
                            <li>• Pembeli akan bisa bidding setelah lelang aktif</li>
                        </ul>
                    </div>

                    {{-- Tombol --}}
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 py-4 rounded-xl text-white font-bold text-lg hover:scale-[1.02] transition duration-300"
                    >
                        🚀 Buat Lelang
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
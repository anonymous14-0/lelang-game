<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            ➕ Tambah Kategori
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8 px-6">
        <div class="max-w-4xl mx-auto">

            <div class="bg-slate-800 border border-slate-700 rounded-3xl shadow-2xl p-8">

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-white">
                        Tambah Kategori Baru
                    </h1>

                    <p class="text-gray-400 mt-2">
                        Tambahkan kategori item game untuk marketplace
                    </p>
                </div>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Kategori --}}
                    <div>
                        <label class="block mb-2 text-gray-300 font-semibold">
                            Nama Kategori
                        </label>

                        <input
                            type="text"
                            name="name"
                            required
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            placeholder="Contoh: Mobile Legends"
                        >

                        @error('name')
                            <p class="text-red-400 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block mb-2 text-gray-300 font-semibold">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            placeholder="Masukkan deskripsi kategori..."
                        ></textarea>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-slate-700 border border-slate-600 rounded-2xl p-4">
                        <p class="text-blue-400 font-semibold mb-2">
                            💡 Tips
                        </p>

                        <ul class="text-gray-300 text-sm space-y-1">
                            <li>• Gunakan nama kategori yang mudah dipahami</li>
                            <li>• Contoh: PUBG, Mobile Legends, Valorant</li>
                            <li>• Hindari kategori duplikat</li>
                        </ul>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-4">
                        <button
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 py-3 rounded-xl font-bold text-white hover:scale-[1.02] transition"
                        >
                            💾 Simpan Kategori
                        </button>

                        <a
                            href="{{ route('admin.categories.index') }}"
                            class="px-6 py-3 bg-slate-600 rounded-xl text-white font-semibold hover:bg-slate-500 transition"
                        >
                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
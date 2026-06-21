<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            🎮 Tambah Item Game
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8 px-6">

        <div class="max-w-4xl mx-auto">
            <div class="bg-slate-800 rounded-3xl shadow-2xl border border-slate-700 p-8">

                <form action="{{ route('penjual.items.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    {{-- Judul Item --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Judul Item
                        </label>

                        <input
                            type="text"
                            name="title"
                            required
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            placeholder="Contoh: Skin Legend Gusion"
                        >
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Kategori
                        </label>

                        <select
                            name="category_id"
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                        >
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            placeholder="Masukkan deskripsi item..."
                        ></textarea>
                    </div>

                    {{-- Harga Awal --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Harga Awal
                        </label>

                        <input
                            type="number"
                            name="starting_price"
                            required
                            class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            placeholder="100000"
                        >
                    </div>

                    {{-- Upload Gambar --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-semibold">
                            Gambar Item
                        </label>

                        <div class="border-2 border-dashed border-slate-500 rounded-2xl p-6 bg-slate-700">
                            <input
                                type="file"
                                name="image"
                                class="w-full text-gray-300"
                            >

                            <p class="text-gray-400 text-sm mt-2">
                                Upload gambar item (.jpg, .png)
                            </p>
                        </div>
                    </div>

                    {{-- Button --}}
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 py-4 rounded-xl font-bold text-white text-lg hover:scale-[1.02] transition duration-300"
                    >
                        🚀 Simpan Item
                    </button>

                </form>
            </div>
        </div>

    </div>
</x-app-layout>
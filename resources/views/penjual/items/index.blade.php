<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    🎮 Daftar Item Saya
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola semua item game yang akan dilelang
                </p>
            </div>

            <a href="{{ route('penjual.items.create') }}"
               class="inline-flex items-center px-5 py-3 rounded-xl
                      bg-purple-600 hover:bg-purple-700
                      text-white shadow-md transition">
                + Tambah Item
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 md:px-6">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 border-b">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Gambar</th>
                            <th class="px-6 py-4 font-semibold">Judul</th>
                            <th class="px-6 py-4 font-semibold">Kategori</th>
                            <th class="px-6 py-4 font-semibold">Harga Awal</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                {{-- Gambar --}}
                                <td class="px-6 py-4">
                                    @if($item->image)
                                        <img
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->title }}"
                                            class="w-20 h-20 object-cover rounded-xl shadow"
                                        >
                                    @else
                                        <div class="w-20 h-20 rounded-xl bg-gray-200 dark:bg-gray-600
                                                    flex items-center justify-center text-xs text-gray-500">
                                            No Image
                                        </div>
                                    @endif
                                </td>

                                {{-- Judul --}}
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">
                                    {{ $item->title }}
                                </td>

                                {{-- Kategori --}}
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $item->category->name }}
                                </td>

                                {{-- Harga --}}
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                                    Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($item->status === 'available')
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                                     bg-green-100 text-green-700">
                                            Available
                                        </span>
                                    @elseif($item->status === 'sold')
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                                     bg-red-100 text-red-700">
                                            Sold
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                                     bg-yellow-100 text-yellow-700">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="text-5xl">📦</div>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            Belum ada item yang ditambahkan
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Item Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('penjual.items.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">
                + Tambah Item
            </a>

            <div class="bg-white dark:bg-gray-800 mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left p-2">Gambar</th>
                                <th class="text-left p-2">Judul</th>
                                <th class="text-left p-2">Kategori</th>
                                <th class="text-left p-2">Harga Awal</th>
                                <th class="text-left p-2">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="p-2">
                                        @if($item->image)
                                            <img
                                                src="{{ asset('storage/' . $item->image) }}"
                                                alt="{{ $item->title }}"
                                                class="w-20 h-20 object-cover rounded">
                                        @else
                                            Tidak ada gambar
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        {{ $item->title }}
                                    </td>

                                    <td class="p-2">
                                        {{ $item->category->name }}
                                    </td>

                                    <td class="p-2">
                                        Rp {{ number_format($item->starting_price, 0, ',', '.') }}
                                    </td>

                                    <td class="p-2">
                                        {{ $item->status }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-2 text-center">
                                        Belum ada item
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
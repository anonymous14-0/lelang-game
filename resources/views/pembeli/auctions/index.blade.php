<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Semua Lelang
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($auctions as $auction)

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">

                    {{-- Gambar --}}
                    @if($auction->item->image)
                        <img
                            src="{{ asset('storage/' . $auction->item->image) }}"
                            alt="{{ $auction->item->title }}"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-48 bg-gray-300 rounded-lg flex items-center justify-center mb-4">
                            No Image
                        </div>
                    @endif

                    {{-- Judul --}}
                    <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
                        {{ $auction->item->title }}
                    </h3>

                    {{-- Harga --}}
                    <p class="text-green-600 font-semibold mb-2">
                        Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                    </p>

                    {{-- End Time --}}
                    <p class="text-sm text-gray-500 mb-4">
                        Berakhir: {{ $auction->end_time }}
                    </p>

                    {{-- Tombol --}}
                    <a
                        href="{{ route('pembeli.auctions.show', $auction->id) }}"
                        class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">

                        Detail Lelang
                    </a>

                </div>

            @empty

                <div class="col-span-3 text-center py-10">
                    Belum ada lelang aktif
                </div>

            @endforelse
        </div>
    </div>
</x-app-layout>
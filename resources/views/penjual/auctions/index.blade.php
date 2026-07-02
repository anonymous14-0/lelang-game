<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    🎮 Daftar Lelang Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola semua item lelang yang sedang berjalan
                </p>
            </div>

            <a href="{{ route('penjual.auctions.create') }}"
               class="inline-flex items-center bg-purple-600 hover:bg-purple-700
                      text-white px-5 py-3 rounded-xl shadow-md transition">
                + Buat Lelang
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 md:px-6">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-700">Item</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Harga Saat Ini</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Berakhir</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse($auctions as $auction)
                            <tr class="hover:bg-gray-50 transition">

                                {{-- Item --}}
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $auction->item->title }}
                                </td>

                                {{-- Harga --}}
                                <td class="px-6 py-4 text-gray-700">
                                    Rp {{ number_format($auction->current_price, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($auction->status === 'aktif')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                            Aktif
                                        </span>
                                    @elseif($auction->status === 'selesai')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                                            {{ ucfirst($auction->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- End Time --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada lelang yang dibuat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
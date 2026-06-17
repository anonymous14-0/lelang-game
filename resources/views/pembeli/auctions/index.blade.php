<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Semua Lelang
        </h2>
    </x-slot>

    <div class="p-6">

        <table class="w-full">

            <thead>
                <tr>
                    <th>Item</th>
                    <th>Harga Saat Ini</th>
                    <th>Berakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($auctions as $auction)

                <tr>
                    <td>
                        {{ $auction->item->title }}
                    </td>

                    <td>
                        Rp {{ number_format($auction->current_price,0,',','.') }}
                    </td>

                    <td>
                        {{ $auction->end_time }}
                    </td>

                    <td>
                        <a
                            href="{{ route('pembeli.auctions.show', $auction->id) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded">

                            Detail

                        </a>
                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</x-app-layout>
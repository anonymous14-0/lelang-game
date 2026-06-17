<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Daftar Lelang Saya
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="{{ route('penjual.auctions.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">

            + Buat Lelang

        </a>

        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Berakhir</th>
                </tr>
            </thead>

            <tbody>
                @foreach($auctions as $auction)
                <tr>
                    <td>{{ $auction->item->title }}</td>
                    <td>
                        Rp {{ number_format($auction->current_price,0,',','.') }}
                    </td>
                    <td>{{ $auction->status }}</td>
                    <td>{{ $auction->end_time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
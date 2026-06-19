<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Buat Lelang
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('penjual.auctions.store') }}"
              method="POST">

            @csrf

            <div class="mb-4">
                <label>Item</label>
                <select
                    name="item_id"
                    class="border rounded w-full p-2 bg-white text-black">

                    @foreach($items as $item)
                        <option
                            value="{{ $item->id }}"
                            class="text-black bg-white">

                            {{ $item->id }} - {{ $item->title }}

                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-4">
                <label>Tanggal Mulai</label>

                <input
                    type="datetime-local"
                    name="start_time"
                    class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Tanggal Selesai</label>

                <input
                    type="datetime-local"
                    name="end_time"
                    class="border rounded w-full p-2">
            </div>

            <button
                type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded">

                Buat Lelang

            </button>

        </form>

    </div>
</x-app-layout>
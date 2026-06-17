<x-app-layout>

    <div class="p-6">

        <h1 class="text-2xl font-bold">
            {{ $auction->item->title }}
        </h1>

        <p>
            Harga Saat Ini:
            Rp {{ number_format($auction->current_price,0,',','.') }}
        </p>
        @if(session('success'))
            <div class="bg-green-100 p-3 mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 p-3 mb-3">
                {{ session('error') }}
            </div>
        @endif
        <form
            action="{{ route('bids.store',$auction->id) }}"
            method="POST">

            @csrf

            <input
                type="number"
                name="amount"
                class="border rounded p-2 w-full">

            <button
                class="bg-green-600 text-white px-4 py-2 mt-2 rounded">

                Tawar

            </button>
        
        </form>

    </div>

</x-app-layout>
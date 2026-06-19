<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">
            Verifikasi Pembayaran
        </h2>
    </x-slot>

    <div class="p-6">

        @foreach($transactions as $transaction)

            <div class="border p-4 rounded mb-4">

                <h3>
                    {{ $transaction->auction->item->title }}
                </h3>

                <p>Buyer: {{ $transaction->buyer->name }}</p>
                <p>Status: {{ $transaction->status }}</p>
                <p>Nominal: Rp {{ number_format($transaction->amount,0,',','.') }}</p>

                @if($transaction->payment_proof)
                    <img
                        src="{{ asset('storage/'.$transaction->payment_proof) }}"
                        class="w-48 mb-3">
                @endif

                <form
                    action="{{ route('admin.transactions.verify',$transaction->id) }}"
                    method="POST"
                    class="inline">

                    @csrf

                    <button class="bg-green-500 text-white px-3 py-1 rounded">
                        Verifikasi
                    </button>
                </form>

                <form
                    action="{{ route('admin.transactions.reject',$transaction->id) }}"
                    method="POST"
                    class="inline">

                    @csrf

                    <input
                        type="text"
                        name="admin_note"
                        placeholder="Alasan ditolak"
                        class="border p-1 rounded">

                    <button class="bg-red-500 text-white px-3 py-1 rounded">
                        Tolak
                    </button>
                </form>

            </div>

        @endforeach

    </div>
</x-app-layout>
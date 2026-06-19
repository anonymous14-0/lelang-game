<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">
            Transaksi Saya
        </h2>
    </x-slot>

    <div class="p-6">

        @foreach($transactions as $transaction)

            <div class="border rounded p-4 mb-4">

                <h3>
                    {{ $transaction->auction->item->title }}
                </h3>

                <p>
                    Nominal:
                    Rp {{ number_format($transaction->amount,0,',','.') }}
                </p>

                <p>
                    Status:
                    {{ $transaction->status }}
                </p>

                @if(!$transaction->payment_proof)

                    <form
                        action="{{ route('pembeli.transactions.upload',$transaction->id) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <input
                            type="file"
                            name="payment_proof">

                        <button
                            class="bg-blue-500 text-white px-3 py-1 rounded">

                            Upload Bukti Transfer

                        </button>

                    </form>

                @endif

                <a
                    href="{{ route('pembeli.transactions.show', $transaction->id) }}"
                    class="bg-green-500 text-white px-3 py-1 rounded inline-block mt-3">

                    Detail

                </a>

            </div>

        @endforeach

    </div>
</x-app-layout>
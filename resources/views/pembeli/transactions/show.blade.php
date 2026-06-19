<x-app-layout>

    <div class="p-6">

        @if(session('success'))
            <div class="bg-green-100 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-4">
            Detail Transaksi
        </h2>

        <div class="border rounded p-4">

            <p>
                <strong>Item:</strong>
                {{ $transaction->auction->item->title }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $transaction->status }}
            </p>

            @if($transaction->status === 'account_sent')

                <hr class="my-4">

                <p>
                    <strong>Email:</strong>
                    {{ $transaction->account_email }}
                </p>

                <p>
                    <strong>Password:</strong>
                    {{ $password }}
                </p>

                <p>
                    <strong>Catatan Seller:</strong>
                    {{ $transaction->seller_note ?? '-' }}
                </p>

                <form
                    action="{{ route('pembeli.transactions.complete', $transaction->id) }}"
                    method="POST"
                    class="mt-4">

                    @csrf

                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Akun Diterima
                    </button>
                </form>

            @elseif($transaction->status === 'completed')

                <hr class="my-4">

                <p>
                    <strong>Email:</strong>
                    {{ $transaction->account_email }}
                </p>

                <p>
                    <strong>Password:</strong>
                    {{ $password }}
                </p>

                <p>
                    <strong>Catatan Seller:</strong>
                    {{ $transaction->seller_note ?? '-' }}
                </p>

                <p class="text-green-600 font-bold mt-4">
                    Transaksi telah selesai
                </p>

            @else

                <p class="mt-4">
                    Penjual belum mengirim akun.
                </p>

            @endif

        </div>

    </div>

</x-app-layout>
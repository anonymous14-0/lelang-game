<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">
            Kirim Akun Game
        </h2>
    </x-slot>

    <div class="p-6">

        @foreach($transactions as $transaction)

            <div class="border p-4 rounded mb-4">

                <h3>
                    {{ $transaction->auction->item->title }}
                </h3>

                <p>Buyer: {{ $transaction->buyer->name }}</p>

                <form
                    action="{{ route('penjual.transactions.send',$transaction->id) }}"
                    method="POST">

                    @csrf

                    <input
                        type="email"
                        name="account_email"
                        placeholder="Email akun"
                        class="border p-2 w-full mb-2">

                    <input
                        type="text"
                        name="account_password"
                        placeholder="Password akun"
                        class="border p-2 w-full mb-2">

                    <textarea
                        name="seller_note"
                        placeholder="Catatan"
                        class="border p-2 w-full mb-2"></textarea>

                    <button
                        class="bg-blue-500 text-white px-4 py-2 rounded">

                        Kirim Akun

                    </button>

                </form>

            </div>

        @endforeach

    </div>
</x-app-layout>
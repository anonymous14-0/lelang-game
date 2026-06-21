<x-app-layout>
    <div class="p-6">

        {{-- Alert --}}
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-300 p-4 rounded-xl mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-300 p-4 rounded-xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold text-white mb-6">
            💳 Detail Transaksi
        </h2>

        <div class="bg-slate-800 rounded-2xl shadow-lg p-6 border border-slate-700">

            {{-- Item --}}
            <div class="mb-6">
                <p class="text-gray-400">Item</p>
                <h3 class="text-2xl font-bold text-white">
                    {{ $transaction->auction->item->title }}
                </h3>
            </div>

            {{-- Nominal --}}
            <div class="mb-6">
                <p class="text-gray-400">Nominal</p>
                <h3 class="text-3xl font-bold text-green-400">
                    Rp {{ number_format($transaction->amount,0,',','.') }}
                </h3>
            </div>

            {{-- Status --}}
            @php
                $statusColor = match($transaction->status) {
                    'pending' => 'bg-yellow-500',
                    'paid' => 'bg-blue-500',
                    'account_sent' => 'bg-purple-500',
                    'completed' => 'bg-green-500',
                    default => 'bg-gray-500'
                };
            @endphp

            <div class="mb-6">
                <span class="{{ $statusColor }} px-4 py-2 rounded-full text-white font-bold">
                    {{ strtoupper($transaction->status) }}
                </span>
            </div>

            {{-- Jika seller kirim akun --}}
            @if($transaction->status === 'account_sent')

                <hr class="border-slate-700 my-6">

                <div class="bg-slate-700 rounded-xl p-5">
                    <h3 class="text-xl font-bold text-white mb-4">
                        🎮 Detail Akun Game
                    </h3>

                    <p class="mb-3 text-gray-300">
                        <strong>Email:</strong>
                        {{ $transaction->account_email }}
                    </p>

                    <p class="mb-3 text-gray-300">
                        <strong>Password:</strong>
                        {{ $password }}
                    </p>

                    <p class="text-gray-300">
                        <strong>Catatan Seller:</strong>
                        {{ $transaction->seller_note ?? '-' }}
                    </p>
                </div>

                <form
                    action="{{ route('pembeli.transactions.complete', $transaction->id) }}"
                    method="POST"
                    class="mt-6"
                >
                    @csrf

                    <button class="w-full bg-gradient-to-r from-green-500 to-emerald-500 py-3 rounded-xl text-white font-bold hover:scale-105 transition">
                        Akun Diterima
                    </button>
                </form>

            @elseif($transaction->status === 'completed')

                <hr class="border-slate-700 my-6">

                <div class="bg-slate-700 rounded-xl p-5">
                    <h3 class="text-xl font-bold text-white mb-4">
                        🎮 Detail Akun
                    </h3>

                    <p class="mb-3 text-gray-300">
                        <strong>Email:</strong>
                        {{ $transaction->account_email }}
                    </p>

                    <p class="mb-3 text-gray-300">
                        <strong>Password:</strong>
                        {{ $password }}
                    </p>

                    <p class="text-gray-300">
                        <strong>Catatan Seller:</strong>
                        {{ $transaction->seller_note ?? '-' }}
                    </p>
                </div>

                <p class="text-green-400 font-bold text-xl mt-5">
                    ✅ Transaksi telah selesai
                </p>

            @else

                {{-- Payment Instruction --}}
                <div class="bg-blue-900/30 border border-blue-700 rounded-2xl p-6 mt-4">
                    <h3 class="text-xl font-bold text-white mb-4">
                        🏦 Instruksi Pembayaran
                    </h3>

                    <div class="bg-slate-700 rounded-xl p-4">
                        <p class="text-gray-400">payment</p>
                        <p class="text-white font-bold">
                            DANA
                        </p>

                        <p class="text-gray-400 mt-3">
                            Nomor DANA
                        </p>

                        <p class="text-green-400 text-2xl font-bold">
                            081215692885
                        </p>

                        <p class="text-gray-400 mt-3">
                            Atas Nama
                        </p>

                        <p class="text-white">
                            Jemi Gaming
                        </p>
                    </div>

                    <div class="mt-4 bg-yellow-500/20 border border-yellow-500 rounded-xl p-4">
                        <p class="text-yellow-300 font-semibold">
                            ⚠ Transfer sesuai nominal berikut
                        </p>

                        <p class="text-3xl font-bold text-green-400 mt-2">
                            Rp {{ number_format($transaction->amount,0,',','.') }}
                        </p>
                    </div>

                    <p class="text-gray-300 mt-4">
                        Setelah transfer, upload bukti pembayaran.
                    </p>
                </div>

                {{-- Upload Bukti --}}
                @if(!$transaction->payment_proof)
                    <form
                        action="{{ route('pembeli.transactions.upload',$transaction->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-6"
                    >
                        @csrf

                        <input
                            type="file"
                            name="payment_proof"
                            class="block w-full bg-slate-700 rounded-xl p-3 text-white mb-4"
                        >

                        <button
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-500 py-3 rounded-xl text-white font-bold hover:scale-105 transition"
                        >
                            Upload Bukti Transfer
                        </button>
                    </form>
                @else
                    <div class="mt-6 bg-green-500/20 border border-green-500 p-4 rounded-xl text-green-300">
                        Bukti transfer sudah diupload. Menunggu verifikasi admin.
                    </div>
                @endif

            @endif

        </div>
    </div>
</x-app-layout>
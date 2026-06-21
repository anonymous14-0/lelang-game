<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            💳 Transaksi Saya
        </h2>
    </x-slot>

    <div class="p-6">

        @forelse($transactions as $transaction)
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 mb-6 shadow-lg hover:border-blue-500 transition">

                <div class="flex flex-col md:flex-row gap-6">

                    {{-- Gambar Item --}}
                    <div class="w-full md:w-40 h-40 shrink-0">
                        @if($transaction->auction->item->image)
                            <img
                                src="{{ asset('storage/' . $transaction->auction->item->image) }}"
                                class="w-full h-full object-cover rounded-xl"
                            >
                        @else
                            <div class="w-full h-full bg-slate-700 rounded-xl flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                        @endif
                    </div>

                    {{-- Detail --}}
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white">
                            {{ $transaction->auction->item->title }}
                        </h3>

                        <p class="text-gray-400 mt-3">
                            Nominal Transaksi
                        </p>

                        <p class="text-green-400 text-3xl font-bold">
                            Rp {{ number_format($transaction->amount,0,',','.') }}
                        </p>

                        @php
                            $statusColor = match($transaction->status) {
                                'pending' => 'bg-yellow-500',
                                'paid' => 'bg-blue-500',
                                'completed' => 'bg-green-500',
                                'rejected' => 'bg-red-500',
                                default => 'bg-gray-500'
                            };
                        @endphp

                        <div class="mt-4">
                            <span class="{{ $statusColor }} px-4 py-2 rounded-full text-white font-semibold">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>

                        {{-- Upload Bukti --}}
                        @if(!$transaction->payment_proof)
                            <form
                                action="{{ route('pembeli.transactions.upload',$transaction->id) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="mt-5"
                            >
                                @csrf

                                <input
                                    type="file"
                                    name="payment_proof"
                                    class="block w-full text-gray-300 bg-slate-700 rounded-lg p-2 mb-3"
                                >

                                <button
                                    class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-5 py-3 rounded-xl font-bold hover:scale-105 transition"
                                >
                                    Upload Bukti Transfer
                                </button>
                            </form>
                        @endif

                        {{-- Tombol Detail --}}
                        <a
                            href="{{ route('pembeli.transactions.show', $transaction->id) }}"
                            class="inline-block mt-5 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-5 py-3 rounded-xl font-bold hover:scale-105 transition"
                        >
                            Detail
                        </a>
                    </div>
                </div>
            </div>

        @empty
            <div class="bg-slate-800 rounded-2xl p-10 text-center text-gray-400">
                Belum ada transaksi
            </div>
        @endforelse

    </div>
</x-app-layout>
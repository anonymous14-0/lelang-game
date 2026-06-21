<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            🛡 Verifikasi Pembayaran
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8 px-6">
        <div class="max-w-7xl mx-auto space-y-6">

            @forelse($transactions as $transaction)

                <div class="bg-slate-800 border border-slate-700 rounded-3xl shadow-xl p-6">

                    {{-- Header --}}
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-white">
                                {{ $transaction->auction->item->title }}
                            </h3>

                            <p class="text-gray-400 mt-2">
                                Buyer:
                                <span class="text-blue-400 font-semibold">
                                    {{ $transaction->buyer->name }}
                                </span>
                            </p>

                            <p class="text-gray-400 mt-1">
                                Nominal:
                                <span class="text-green-400 font-bold">
                                    Rp {{ number_format($transaction->amount,0,',','.') }}
                                </span>
                            </p>
                        </div>

                        @php
                            $statusColor = match($transaction->status) {
                                'pending' => 'bg-yellow-500',
                                'paid' => 'bg-blue-500',
                                'verified' => 'bg-green-500',
                                default => 'bg-gray-500'
                            };
                        @endphp

                        <span class="{{ $statusColor }} px-4 py-2 rounded-xl text-white font-semibold">
                            {{ strtoupper($transaction->status) }}
                        </span>
                    </div>

                    {{-- Bukti Transfer --}}
                    <div class="mb-6">
                        <p class="text-gray-300 font-semibold mb-3">
                            Bukti Transfer
                        </p>

                        @if($transaction->payment_proof)
                            <img
                                src="{{ asset('storage/'.$transaction->payment_proof) }}"
                                class="w-72 rounded-2xl border border-slate-600 shadow-lg"
                            >
                        @else
                            <div class="bg-slate-700 rounded-xl p-4 text-gray-400">
                                Belum ada bukti transfer
                            </div>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- Verify --}}
                        <form
                            action="{{ route('admin.transactions.verify',$transaction->id) }}"
                            method="POST"
                        >
                            @csrf

                            <button
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 py-3 rounded-xl text-white font-bold hover:scale-[1.02] transition"
                            >
                                ✅ Verifikasi Pembayaran
                            </button>
                        </form>

                        {{-- Reject --}}
                        <form
                            action="{{ route('admin.transactions.reject',$transaction->id) }}"
                            method="POST"
                            class="space-y-3"
                        >
                            @csrf

                            <input
                                type="text"
                                name="admin_note"
                                placeholder="Masukkan alasan penolakan"
                                class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 focus:ring-2 focus:ring-red-500 focus:outline-none"
                            >

                            <button
                                class="w-full bg-gradient-to-r from-red-500 to-rose-600 py-3 rounded-xl text-white font-bold hover:scale-[1.02] transition"
                            >
                                ❌ Tolak Pembayaran
                            </button>
                        </form>

                    </div>
                </div>

            @empty
                <div class="bg-slate-800 rounded-3xl p-12 text-center text-gray-400">
                    Tidak ada transaksi yang perlu diverifikasi
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
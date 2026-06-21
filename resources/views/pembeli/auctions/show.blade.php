<script>
document.addEventListener("DOMContentLoaded", function () {

    const countdownElement = document.getElementById("countdown");

    const endTime = new Date(
        "{{ \Carbon\Carbon::parse($auction->end_time)->toIso8601String() }}"
    ).getTime();

    const timer = setInterval(function () {

        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance <= 0) {
            clearInterval(timer);
            countdownElement.innerHTML = "LELANG BERAKHIR";
            countdownElement.classList.remove("text-blue-400");
            countdownElement.classList.add("text-red-500");
            return;
        }

        const days = Math.floor(distance / (1000*60*60*24));
        const hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
        const minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
        const seconds = Math.floor((distance % (1000*60)) / 1000);

        countdownElement.innerHTML =
            `${days}h ${hours}j ${minutes}m ${seconds}d`;

    }, 1000);
});
</script>
<x-app-layout>
    <div class="p-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- LEFT: IMAGE --}}
            <div class="bg-slate-800 rounded-2xl p-4 shadow-lg">
                @if($auction->item->image)
                    <img
                        src="{{ asset('storage/' . $auction->item->image) }}"
                        alt="{{ $auction->item->title }}"
                        class="w-full h-[450px] object-cover rounded-xl"
                    >
                @else
                    <div class="w-full h-[450px] bg-gray-300 rounded-xl flex items-center justify-center">
                        No Image
                    </div>
                @endif
            </div>

            {{-- RIGHT: DETAIL --}}
            <div class="bg-slate-800 rounded-2xl p-6 shadow-lg">

                {{-- Title --}}
                <h1 class="text-3xl font-bold text-white mb-4">
                    {{ $auction->item->title }}
                </h1>

                {{-- Price --}}
                <div class="mb-4">
                    <p class="text-gray-400">Harga Saat Ini</p>
                    <h2 class="text-4xl font-bold text-green-400">
                        Rp {{ number_format($auction->current_price,0,',','.') }}
                    </h2>
                </div>

                {{-- Countdown --}}
                <div class="mb-6 bg-slate-700 rounded-xl p-4">
                    <p class="text-gray-300 mb-2">Berakhir dalam</p>

                    <p
                        id="countdown"
                        class="text-2xl font-bold text-blue-400"
                    >
                        Loading...
                    </p>
                </div>

                {{-- Bid Form --}}
                <form action="{{ route('bids.store', $auction->id) }}" method="POST">
                    @csrf

                    <label class="block text-gray-300 mb-2">
                        Masukkan Bid
                    </label>

                    <input
                        type="number"
                        name="amount"
                        class="w-full rounded-xl bg-slate-700 border border-slate-600 text-white px-4 py-3 mb-4"
                        placeholder="Masukkan nominal bid"
                    >

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-blue-500 py-3 rounded-xl font-bold text-white hover:scale-105 transition"
                    >
                        🚀 Tawar Sekarang
                    </button>
                </form>

            </div>
        </div>

        {{-- BID HISTORY --}}
        <div class="mt-8 bg-slate-800 rounded-2xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-white mb-4">
                Riwayat Bid
            </h2>

            @forelse($auction->bids as $bid)
                <div class="flex justify-between items-center border-b border-slate-700 py-3">
                    <div>
                        <p class="text-white font-semibold">
                            {{ $bid->user->name }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            {{ $bid->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <p class="text-green-400 font-bold text-lg">
                        Rp {{ number_format($bid->amount,0,',','.') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-400">
                    Belum ada bid.
                </p>
            @endforelse
        </div>

    </div>
</x-app-layout>
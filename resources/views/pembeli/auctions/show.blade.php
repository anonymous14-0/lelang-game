<x-app-layout>

    <div class="p-6">
        @if($auction->item->image)
            <img
                src="{{ asset('storage/' . $auction->item->image) }}"
                alt="{{ $auction->item->title }}"
                class="w-64 h-64 object-cover rounded mb-4">
        @endif

        <h1 class="text-2xl font-bold">
            {{ $auction->item->title }}
        </h1>

        <p>
            Harga Saat Ini:
            Rp {{ number_format($auction->current_price, 0, ',', '.') }}
        </p>

        <p class="mt-2">
            <strong>Berakhir dalam:</strong>
            <span
                id="countdown"
                class="font-bold text-blue-600">
            </span>
        </p>

        @if(session('success'))
            <div class="bg-green-100 p-3 mb-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 p-3 mb-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form
            action="{{ route('bids.store', $auction->id) }}"
            method="POST">

            @csrf

            <input
                type="number"
                name="amount"
                class="border rounded p-2 w-full">

            <button
                id="bidButton"
                class="bg-green-600 text-white px-4 py-2 mt-2 rounded">

                Tawar

            </button>

        </form>

        <hr class="my-6">

        <h2 class="text-xl font-bold mb-3">
            Riwayat Bid
        </h2>

        @if($auction->bids->count())

            @php
                $highest = $auction->bids->max('amount');
            @endphp

            <table class="w-full border">
                <thead>
                    <tr>
                        <th class="border p-2">User</th>
                        <th class="border p-2">Bid</th>
                        <th class="border p-2">Waktu</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($auction->bids->sortByDesc('amount') as $bid)

                        <tr class="{{ $bid->amount == $highest ? 'bg-green-100' : '' }}">

                            <td class="border p-2">
                                {{ $bid->user->name }}
                            </td>

                            <td class="border p-2">
                                Rp {{ number_format($bid->amount, 0, ',', '.') }}
                            </td>

                            <td class="border p-2">
                                {{ $bid->created_at }}
                            </td>

                        </tr>

                    @endforeach
                </tbody>
            </table>

        @else

            <p>Belum ada bid.</p>

        @endif

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const countdownElement =
                document.getElementById("countdown");

            const bidButton =
                document.getElementById("bidButton");

            const endTime = new Date(
                "{{ \Carbon\Carbon::parse($auction->end_time)->toIso8601String() }}"
            ).getTime();

            const timer = setInterval(function () {

                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    clearInterval(timer);

                    countdownElement.innerHTML =
                        "LELANG BERAKHIR";

                    countdownElement.classList.remove("text-blue-600");
                    countdownElement.classList.add("text-red-600");

                    if (bidButton) {
                        bidButton.disabled = true;
                        bidButton.classList.add("opacity-50");
                    }

                    return;
                }

                const days = Math.floor(
                    distance / (1000 * 60 * 60 * 24)
                );

                const hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) /
                    (1000 * 60 * 60)
                );

                const minutes = Math.floor(
                    (distance % (1000 * 60 * 60)) /
                    (1000 * 60)
                );

                const seconds = Math.floor(
                    (distance % (1000 * 60)) / 1000
                );

                countdownElement.innerHTML =
                    days + "h " +
                    hours + "j " +
                    minutes + "m " +
                    seconds + "d";

                if (distance < 3600000) {
                    countdownElement.classList.remove("text-blue-600");
                    countdownElement.classList.add("text-red-600");
                }

            }, 1000);
        });
    </script>

</x-app-layout>
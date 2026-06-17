<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Tambah Item Game
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('penjual.items.store') }}"
              method="POST">

            @csrf

            <div class="mb-4">
                <label>Judul Item</label>

                <input
                    type="text"
                    name="title"
                    class="border rounded w-full p-2"
                    required>
            </div>

            <div class="mb-4">
                <label>Kategori</label>

                <select
                    name="category_id"
                    class="border rounded w-full p-2">

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-4">
                <label>Deskripsi</label>

                <textarea
                    name="description"
                    class="border rounded w-full p-2"></textarea>
            </div>

            <div class="mb-4">
                <label>Harga Awal</label>

                <input
                    type="number"
                    name="starting_price"
                    class="border rounded w-full p-2"
                    required>
            </div>

            <button
                type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded">

                Simpan Item

            </button>

        </form>

    </div>
</x-app-layout>
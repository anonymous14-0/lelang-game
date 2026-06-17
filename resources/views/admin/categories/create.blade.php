<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Kategori
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="w-full border rounded px-3 py-2"
                                required
                            >

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="w-full border rounded px-3 py-2"
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded"
                        >
                            Simpan Kategori
                        </button>

                        <a
                            href="{{ route('admin.categories.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded"
                        >
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
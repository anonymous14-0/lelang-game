<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6">

        <h3 class="text-lg font-bold mb-4">
            Selamat datang {{ auth()->user()->name }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <a href="{{ route('admin.categories.index') }}"
               class="bg-blue-500 text-white p-4 rounded shadow">
                Kelola Kategori
            </a>

        </div>

    </div>
</x-app-layout>
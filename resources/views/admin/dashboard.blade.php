<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="p-6">
        Selamat datang {{ auth()->user()->name }}
    </div>
</x-app-layout>
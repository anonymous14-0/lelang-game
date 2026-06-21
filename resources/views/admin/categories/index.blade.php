<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            🗂 Kelola Kategori
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-950 py-8 px-6">
        <div class="max-w-7xl mx-auto">

            {{-- Top Bar --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        Daftar Kategori
                    </h1>
                    <p class="text-gray-400">
                        Kelola kategori item game di marketplace
                    </p>
                </div>

                <a href="{{ route('admin.categories.create') }}"
                   class="bg-gradient-to-r from-purple-600 to-blue-600 px-5 py-3 rounded-xl font-semibold text-white hover:scale-105 transition">
                    + Tambah Kategori
                </a>
            </div>

            {{-- Table Card --}}
            <div class="bg-slate-800 border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">

                <table class="w-full">
                    <thead class="bg-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-gray-300">ID</th>
                            <th class="px-6 py-4 text-left text-gray-300">Nama</th>
                            <th class="px-6 py-4 text-left text-gray-300">Deskripsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-t border-slate-700 hover:bg-slate-700/40 transition">
                                <td class="px-6 py-4 text-gray-300">
                                    #{{ $category->id }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg">
                                        {{ $category->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $category->description ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12 text-gray-500">
                                    Belum ada kategori
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
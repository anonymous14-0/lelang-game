<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'pembeli';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults()
            ],
            'role' => ['required', 'in:penjual,pembeli'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        if ($user->role === 'admin') {
            $this->redirect('/admin/dashboard', navigate: true);
            return;
        }

        if ($user->role === 'penjual') {
            $this->redirect('/penjual/dashboard', navigate: true);
            return;
        }

        $this->redirect('/pembeli/dashboard', navigate: true);
    }
};

?>

<div class="w-full max-w-md">
    <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-8">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-purple-700">
                🎮 GameBid
            </h1>

            <h2 class="text-2xl font-semibold text-gray-800 mt-3">
                Selamat Datang di Register
            </h2>

            <p class="text-gray-500 mt-2">
                Silakan buat akun untuk mulai bidding
            </p>
        </div>

        <form wire:submit="register" class="space-y-5">

            {{-- Nama --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Nama
                </label>

                <input
                    wire:model="name"
                    id="name"
                    type="text"
                    placeholder="Masukkan nama"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Email
                </label>

                <input
                    wire:model="email"
                    id="email"
                    type="email"
                    placeholder="Masukkan email"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Daftar Sebagai
                </label>

                <select
                    wire:model="role"
                    id="role"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >
                    <option value="pembeli">Pembeli</option>
                    <option value="penjual">Penjual</option>
                </select>

                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Password
                </label>

                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    placeholder="Masukkan password"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Confirm Password
                </label>

                <input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    placeholder="Ulangi password"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Footer --}}
            <div class="pt-2">
                <div class="text-center text-sm text-gray-500 mb-4">
                    Sudah punya akun?
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        class="text-purple-600 font-semibold hover:underline"
                    >
                        Login
                    </a>
                </div>

                <button
                    type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700
                           text-white py-3 rounded-2xl font-semibold
                           transition duration-200 shadow-md"
                >
                    REGISTER
                </button>
            </div>

        </form>
    </div>
</div>
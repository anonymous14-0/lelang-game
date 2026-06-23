<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        if ($user->role === 'penjual') {
            return redirect('/penjual/dashboard');
        }

        return redirect('/pembeli/dashboard');
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

            <p class="text-gray-500 mt-3 text-sm md:text-base">
                Login untuk mulai bidding item game favoritmu
            </p>
        </div>

        <form wire:submit="login" class="space-y-5">

            {{-- Email --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Email
                </label>

                <input
                    type="email"
                    wire:model="form.email"
                    placeholder="Masukkan email"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('form.email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block mb-2 text-gray-700 font-medium">
                    Password
                </label>

                <input
                    type="password"
                    wire:model="form.password"
                    placeholder="Masukkan password"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3
                           focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('form.password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember --}}
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    wire:model="form.remember"
                    class="w-4 h-4"
                >

                <span class="text-gray-600 text-sm">
                    Remember me
                </span>
            </div>

            {{-- Button --}}
            <button
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700
                       text-white py-3 rounded-2xl font-semibold
                       transition duration-200 shadow-md"
            >
                LOGIN
            </button>

            {{-- Register --}}
            <div class="text-center pt-3 text-gray-500 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="text-purple-600 font-semibold hover:underline">
                    Register
                </a>
            </div>

        </form>
    </div>
</div>
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

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900 px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-700">
                🎮 GameBid
            </h1>

            <p class="text-gray-500 mt-2">
                Login untuk mulai bidding item game favoritmu
            </p>
        </div>

        <form wire:submit="login">

            {{-- Email --}}
            <div class="mb-5">
                <label class="block mb-2 text-gray-700 font-medium">
                    Email
                </label>

                <input
                    type="email"
                    wire:model="form.email"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('form.email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label class="block mb-2 text-gray-700 font-medium">
                    Password
                </label>

                <input
                    type="password"
                    wire:model="form.password"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >

                @error('form.password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember --}}
            <div class="flex items-center mb-6">
                <input
                    type="checkbox"
                    wire:model="form.remember"
                    class="mr-2"
                >
                <span class="text-gray-600">
                    Remember me
                </span>
            </div>

            {{-- Button --}}
            <button
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-semibold transition"
            >
                LOGIN
            </button>

            {{-- Register --}}
            <div class="text-center mt-6 text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="text-purple-600 font-semibold hover:underline">
                    Register
                </a>
            </div>

        </form>
    </div>
</div>
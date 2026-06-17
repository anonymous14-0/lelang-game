<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Penjual Demo',
            'email' => 'penjual@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'penjual',
        ]);

        User::create([
            'name' => 'Pembeli Demo',
            'email' => 'pembeli@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);
    }
}

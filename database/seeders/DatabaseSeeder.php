<?php

/*
|--------------------------------------------------------------------------
| DatabaseSeeder
|--------------------------------------------------------------------------
|
| Seeder ini membuat akun dummy awal untuk presentasi dan pengujian GameBid.
| Data admin, penjual, dan pembeli membantu demo alur MVC/API tanpa registrasi
| manual. Password di-hash sebelum masuk ke tabel users.
|
*/

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Seeder untuk membuat akun demo awal aplikasi.
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    // Menjalankan pembuatan user demo untuk setiap role utama.
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

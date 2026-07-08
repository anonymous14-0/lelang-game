<?php

/*
|--------------------------------------------------------------------------
| Migration: 2026_06_17_114402_create_items_table
|--------------------------------------------------------------------------
|
| File migration ini mendokumentasikan perubahan struktur database MySQL
| GameBid. Kolom-kolom di bawah menjadi sumber data bagi Eloquent Model,
| Controller REST API, dan aplikasi Android yang menerima JSON response.
|
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Membuat tabel baru beserta kolom dan relasinya.
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // Seller pemilik item; cascade membersihkan item jika user dihapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kategori item untuk filter dan tampilan Android.
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Judul item game yang tampil pada kartu auction.
            $table->string('title');
            // Deskripsi detail akun game untuk calon pembeli.
            $table->text('description');

            // Harga awal yang akan disalin ke auction.
            $table->decimal('starting_price', 15, 2);

            // Path gambar item; nullable karena upload gambar bersifat opsional.
            $table->string('image')->nullable();

            // Status item: draft sebelum dilelang, active/sold/closed untuk siklus penjualan.
            $table->enum('status', [
                'draft',
                'active',
                'sold',
                'closed'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel saat rollback migration.
        Schema::dropIfExists('items');
    }
};

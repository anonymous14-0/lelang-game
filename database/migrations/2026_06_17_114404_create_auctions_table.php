<?php

/*
|--------------------------------------------------------------------------
| Migration: 2026_06_17_114404_create_auctions_table
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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            // Item yang dilelang; cascade menjaga auction ikut terhapus jika item dihapus.
            $table->foreignId('item_id')->constrained()->onDelete('cascade');

            // Waktu mulai auction yang ditampilkan pada Android.
            $table->datetime('start_time');
            // Waktu akhir auction; command scheduler dapat memakai kolom ini untuk menutup lelang.
            $table->datetime('end_time');

            // Harga pembuka dari item seller.
            $table->decimal('starting_price', 15, 2);
            // Harga berjalan yang diperbarui setiap bid valid.
            $table->decimal('current_price', 15, 2);

            // User pemenang sementara/akhir; nullable karena auction baru belum memiliki pemenang.
            $table->foreignId('winner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Status auction: active berarti dapat dibid, ended berarti lelang selesai.
            $table->enum('status', [
                'active',
                'ended'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel saat rollback migration.
        Schema::dropIfExists('auctions');
    }
};

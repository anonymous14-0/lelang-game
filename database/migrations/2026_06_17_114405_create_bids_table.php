<?php

/*
|--------------------------------------------------------------------------
| Migration: 2026_06_17_114405_create_bids_table
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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();

            $table->foreignId('auction_id')->constrained()->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel saat rollback migration.
        Schema::dropIfExists('bids');
    }
};

<?php

/*
|--------------------------------------------------------------------------
| Migration: 2026_06_19_141618_add_account_fields_to_transactions_table
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
    public function up(): void
    {
        // Menambahkan kolom akun ke tabel transaksi.
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('account_email')->nullable();

            // pakai text karena hasil encrypt panjang
            $table->text('account_password')->nullable();

            $table->text('seller_note')->nullable();
        });
    }

    public function down(): void
    {
        // Menghapus kolom akun saat rollback migration.
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'account_email',
                'account_password',
                'seller_note'
            ]);
        });
    }
};
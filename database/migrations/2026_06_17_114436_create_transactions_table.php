<?php

/*
|--------------------------------------------------------------------------
| Migration: 2026_06_17_114436_create_transactions_table
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Auction yang dimenangkan dan menjadi sumber transaksi.
            $table->foreignId('auction_id')->constrained();

            // Pembeli/pemenang auction yang wajib menyelesaikan pembayaran.
            $table->foreignId('buyer_id')->constrained('users');

            // Nominal transaksi mengikuti harga akhir auction.
            $table->decimal('amount', 15, 2);
            
            // Catatan admin untuk verifikasi, dispute, atau kebutuhan maintenance.
            $table->text('admin_note')->nullable();
            
            // Status escrow: pending_payment, payment_verified, escrow, account_sent, completed, cancelled, atau dispute.
            $table->enum('status', [
                'pending_payment',
                'payment_verified',
                'escrow',
                'account_sent',
                'completed',
                'cancelled',
                'dispute'
            ])->default('pending_payment');

            // Path bukti transfer yang diupload pembeli melalui Android.
            $table->string('payment_proof')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel saat rollback migration.
        Schema::dropIfExists('transactions');
    }
};

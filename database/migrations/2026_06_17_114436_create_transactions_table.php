<?php

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

            $table->foreignId('auction_id')->constrained();

            $table->foreignId('buyer_id')->constrained('users');

            $table->decimal('amount', 15, 2);
            
            $table->text('admin_note')->nullable();
            
            $table->enum('status', [
                'pending_payment',
                'payment_verified',
                'escrow',
                'account_sent',
                'completed',
                'cancelled',
                'dispute'
            ])->default('pending_payment');

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

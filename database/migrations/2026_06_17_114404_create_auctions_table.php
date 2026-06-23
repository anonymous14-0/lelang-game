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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')->constrained()->onDelete('cascade');

            $table->datetime('start_time');
            $table->datetime('end_time');

            $table->decimal('starting_price', 15, 2);
            $table->decimal('current_price', 15, 2);

            $table->foreignId('winner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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

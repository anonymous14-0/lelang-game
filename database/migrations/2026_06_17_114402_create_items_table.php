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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->text('description');

            $table->decimal('starting_price', 15, 2);

            $table->string('image')->nullable();

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

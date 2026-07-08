<?php

/*
|--------------------------------------------------------------------------
| Migration: 2026_06_30_152851_create_personal_access_tokens_table
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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};

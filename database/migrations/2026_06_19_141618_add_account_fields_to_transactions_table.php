<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('account_email')->nullable();

            // pakai text karena hasil encrypt panjang
            $table->text('account_password')->nullable();

            $table->text('seller_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'account_email',
                'account_password',
                'seller_note'
            ]);
        });
    }
};
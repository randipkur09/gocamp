<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Tambahkan hanya jika kolom belum ada
            if (!Schema::hasColumn('rentals', 'payment_proof')) {
                $table->string('payment_proof')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'payment_proof')) {
                $table->dropColumn('payment_proof');
            }
        });
    }
};

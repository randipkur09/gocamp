<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('days');
            $table->decimal('total_price', 15, 2);
            $table->string('payment_proof')->nullable();

            // Status transaksi
            $table->enum('status', ['pending', 'approved', 'returned'])->default('pending');

            // Tanggal pengembalian
            $table->timestamp('return_date')->nullable();

            // True/false barang dikembalikan
            $table->boolean('is_returned')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};

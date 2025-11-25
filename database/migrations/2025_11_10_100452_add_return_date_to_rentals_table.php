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
        Schema::table('rentals', function (Blueprint $table) {

            if (!Schema::hasColumn('rentals', 'return_date')) {
                $table->date('return_date')->nullable();
            }

            if (!Schema::hasColumn('rentals', 'is_returned')) {
                $table->boolean('is_returned')->default(false);
            }

            if (!Schema::hasColumn('rentals', 'total_price')) {
                $table->integer('total_price')->after('days');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['return_date', 'is_returned', 'total_price']);
        });
    }
};

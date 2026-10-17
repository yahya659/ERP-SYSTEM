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
        Schema::table('suppliers_with_orders_details', function (Blueprint $table) {
            //
            // تاريخ الإنتاج
            $table->date('production_date')->nullable();

            // تاريخ الانتهاء
            $table->date('expir_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers_with_orders_details', function (Blueprint $table) {
            //

        });
    }
};

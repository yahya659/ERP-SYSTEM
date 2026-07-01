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
        Schema::table('item_cards', function (Blueprint $table) {
               $table->decimal('Quantity', 10, 3)
              ->default(10)
              ->after('has_fixed_price');

        $table->decimal('Quantity_retail', 10, 3)
              ->default(10)
              ->after('Quantity');

        $table->decimal('Quantity_all_retail', 10, 3)
              ->default(10)
              ->after('Quantity_retail');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_cards', function (Blueprint $table) {
            //
        });
    }
};

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
            //

        $table->decimal('coast_price', 10, 2)
              ->nullable()
              ->after('wholesale_price_retail');

        $table->decimal('coast_price_retail', 10, 2)
              ->nullable()
              ->after('coast_price');

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

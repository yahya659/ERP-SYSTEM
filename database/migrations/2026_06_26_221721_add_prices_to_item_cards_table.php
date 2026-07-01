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
             $table->decimal('nos_gomla_price_retail', 10, 2)
              ->nullable()
              ->after('nos_gomla_price');

        $table->decimal('wholesale_price_retail', 10, 2)
              ->nullable()
              ->after('nos_gomla_price_retail');

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

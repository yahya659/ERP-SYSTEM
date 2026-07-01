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
            // هل للصنف سعر ثابت ولاييتغير في الفواتير
               $table->tinyInteger('has_fixed_price')
              ->default(1)
              ->after('coast_price_retail');
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

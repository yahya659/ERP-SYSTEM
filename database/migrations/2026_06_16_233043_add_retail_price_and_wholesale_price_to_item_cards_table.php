<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // الااعمده الاضافيه لجدول المنتجات
    public function up(): void
    {
        Schema::table('item_cards', function (Blueprint $table) {
               $table->decimal('retail_price', 10, 2)
            ->default(0)
          
            ->comment('سعر التجزئة');

        $table->decimal('wholesale_price', 10, 2)
            ->default(0)

            ->comment('سعر الجملة');
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

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
       Schema::table('sales_invoice_details', function (Blueprint $table) {
    $table->tinyInteger('sales_item_type')
        ->default(1)
        ->after('item_card_type');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_invoice_details', function (Blueprint $table) {
            //
        });
    }
};

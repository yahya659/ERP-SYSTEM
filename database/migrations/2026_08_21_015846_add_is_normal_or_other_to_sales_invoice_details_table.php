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
    $table->tinyInteger('is_normal_or_other')
          ->default(1)
          ->after('sales_item_type');
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

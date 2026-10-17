<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // تفاصيل فاتوره الااصناف والمشتريات
    public function up(): void
    {
        Schema::create('suppliers_with_orders_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('auto_serial_suppliers_with_orders');
            $table->tinyInteger('order_type');
            $table->decimal('delivery_quantity', 18, 2);
            $table->integer('unit_id');
            $table->tinyInteger('is_main_or_retail_uom');
            $table->decimal('unit_price', 18, 2);
            $table->decimal('total_price', 18, 2);
            $table->date('order_date');
            $table->bigInteger('item_code');
            $table->bigInteger('batch_id');
            $table->integer('com_code');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers_with_orders_details');
    }
};

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
        Schema::create('inv_item_batches', function (Blueprint $table) {
            $table->id();
                        // رقم المخزن الذي يحتوي على الباتش
            $table->foreignId('store_id')
                ->constrained('stores')
                ->onDelete('cascade');

            // كود الصنف الآلي المرتبط بجدول الأصناف
            $table->integer('item_code');

            // رقم وحدة القياس الأساسية للصنف
            $table->foreignId('inv_uoms_id')
                ->constrained('inv_uoms')
                ->onDelete('cascade');

            // سعر شراء الوحدة الواحدة في هذا الباتش
            $table->decimal('unit_cost_price', 10, 2);

            // كمية الصنف الموجودة في هذا الباتش
            $table->decimal('quantity', 10, 2);

            // إجمالي تكلفة الباتش (سعر الوحدة × الكمية)
            $table->decimal('total_cost_price', 10, 2);

            // تاريخ إنتاج الباتش
            $table->date('production_date')->nullable();

            // تاريخ انتهاء صلاحية الباتش
            $table->date('expire_date')->nullable();

            // رقم تسلسلي تلقائي للباتش
            $table->bigInteger('auto_serial')->nullable();

            // هل تم إرسال الباتش إلى الأرشيف/سلة المهملات
            // 0 = موجود، 1 = مؤرشف
            $table->tinyInteger('is_send_archif')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_item_batches');
    }
};

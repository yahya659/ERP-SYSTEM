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
        Schema::create('sales_invoice_return_details', function (Blueprint $table) {
            $table->id();

            // رقم الفاتورة الأصلية
            $table->unsignedBigInteger('auto_serial_sales_invoice')->nullable();

            // نوع بطاقة الصنف
            $table->tinyInteger('item_card_type')->nullable();

            // كود الصنف
            $table->unsignedBigInteger('item_code')->nullable();

            // التاريخ
            $table->date('date')->nullable();

            // نوع الصنف في المبيعات
            $table->tinyInteger('sales_item_type')->nullable();

            // الكمية المرتجعة
            $table->decimal('quantity', 15, 3)->default(0);

            // الوحدة
            $table->unsignedBigInteger('unit_id')->nullable();

            // الخزن
            $table->unsignedBigInteger('store_id')->nullable();

            // هل الوحدة أساسية أم تجزئة
            $table->tinyInteger('is_main_or_retail_uom')->nullable();

            // سعر الوحدة
            $table->decimal('unit_price', 15, 2)->default(0);

            // إجمالي السعر
            $table->decimal('total_price', 15, 2)->default(0);

            // تاريخ الفاتورة
            $table->date('invoice_date')->nullable();

            // رقم الباتش
            $table->unsignedBigInteger('batch_id')->nullable();

            // الشركة
            $table->string('com_code')->nullable();

            // المستخدم الذي أضاف
            $table->unsignedBigInteger('added_by')->nullable();

            // المستخدم الذي عدل
            $table->unsignedBigInteger('updated_by')->nullable();

            // تاريخ الإنتاج
            $table->date('production_date')->nullable();

            // تاريخ الانتهاء
            $table->date('expir_date')->nullable();

            // عادي أم آخر
            $table->tinyInteger('is_normal_or_other')->nullable();
            $table->comment('تفاصيل مرتجع اصناف المبيعات ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_return_details');
    }
};

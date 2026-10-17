<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تفاصيل مبيعات العملاء
     */
   public function up(): void
{
    Schema::create('sales_invoice_details', function (Blueprint $table) {

        $table->id();

        // رقم الفاتورة التسلسلي
        $table->bigInteger('auto_serial_sales_invoice');

        // نوع الطلب / الفاتورة
        $table->tinyInteger('item_card_type')->default(1);//نوعه مخزني او استهلاكي

        // كود الصنف
        $table->bigInteger('item_code');

        // كمية الصنف
        $table->decimal('quantity', 15, 2)->default(0);

        // وحدة الصنف
        $table->bigInteger('unit_id');

        // 1 = وحدة رئيسية | 0 = وحدة تجزئة
        $table->tinyInteger('is_main_or_retail_uom')->default(0);

        // سعر الوحدة
        $table->decimal('unit_price', 15, 2)->default(0);

        // إجمالي سعر الصنف
        $table->decimal('total_price', 15, 2)->default(0);

        // تاريخ الفاتورة
        $table->date('invoice_date')->nullable();

        // رقم الباتش
        $table->bigInteger('batch_id')->nullable();//رقم الباتش الذي تم خروج الصنف منها

        // رقم الشركة
        $table->bigInteger('com_code')->nullable();

        // المستخدم الذي أضاف السجل
        $table->bigInteger('added_by')->nullable();

        // المستخدم الذي قام بالتعديل
        $table->bigInteger('updated_by')->nullable();

        // تاريخ الإنتاج
        $table->date('production_date')->nullable();

        // تاريخ الانتهاء
        $table->date('expir_date')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_details');
    }
};

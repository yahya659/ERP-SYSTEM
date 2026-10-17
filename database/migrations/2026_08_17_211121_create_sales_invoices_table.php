<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *جدول مبيعات العملاء
     */
    public function up(): void
    {
      Schema::create('sales_invoice', function (Blueprint $table) {
    $table->id();

    $table->integer('sales_material_types');//نوع فئه الفاتوره

    $table->bigInteger('auto_serial')->nullable();//رقم الفاتوره اي كود الفاتوره


    $table->date('invoice_date')->nullable();//تاريخ الفاتوره

    // العميل
    $table->bigInteger('customer_code')->nullable();//كود العميل

    $table->tinyInteger('is_approved')->default(0);

    // المبالغ
    $table->decimal('total_before_discount', 15, 2)->default(0);

    $table->tinyInteger('discount_type')->nullable();
    $table->decimal('discount_value', 15, 2)->default(0);

    $table->decimal('tax_percent', 8, 2)->default(0);
    $table->decimal('tax_value', 15, 2)->default(0);

    $table->text('notes')->nullable();//ملاحصات

    $table->decimal('total_cost', 15, 2)->default(0);

    // الحساب المالي للعميل
    $table->bigInteger('account_number')->nullable();
    $table->decimal('money_for_account', 15, 2)->default(0);

    // نوع الفاتورة
    $table->tinyInteger('bill_type')->nullable();//نوع الفاتوره كاش اجل

    // الدفع
    $table->decimal('what_paid', 15, 2)->default(0);
    $table->decimal('what_remain', 15, 2)->default(0);

    // المخزن والخزنة
    // $table->bigInteger('store_id')->nullable();
    $table->bigInteger('treasury_transaction_id')->nullable();

    // رصيد العميل قبل وبعد الفاتورة
    $table->decimal('customer_balance_before', 15, 2)->default(0);
    $table->decimal('customer_balance_after', 15, 2)->default(0);

    // الشركة والمستخدم
    $table->bigInteger('com_code')->nullable();

    $table->bigInteger('added_by')->nullable();
    $table->bigInteger('updated_by')->nullable();
    $table->bigInteger('approved_by')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};

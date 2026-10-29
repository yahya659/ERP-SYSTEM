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
        Schema::create('sales_invoice_return', function (Blueprint $table) {
            $table->id();
          

            // نوع مرتجع المبيعات
            $table->tinyInteger('return_type')->default(1)->comment('نوع المرتجع');

            // نوع مادة / مبيعات الفاتورة
            $table->tinyInteger('sales_material_types')->nullable();

            // الرقم التسلسلي للفاتورة
            $table->bigInteger('auto_serial')->nullable();

            // تاريخ الفاتورة
            $table->date('invoice_date')->nullable();

            // كود العميل
            $table->unsignedBigInteger('customer_code')->nullable();

            // خاص بالمندوب
            $table->unsignedBigInteger('delegate_id')->nullable();

            // هل الفاتورة لها عميل؟
            $table->tinyInteger('is_has_customer')->default(1);

            // حالة اعتماد الفاتورة
            $table->tinyInteger('is_approved')->default(0);

            // الإجمالي قبل الخصم
            $table->decimal('total_before_discount', 15, 2)->default(0);

            // نوع الخصم
            $table->tinyInteger('discount_type')->nullable();

            // قيمة الخصم
            $table->decimal('discount_value', 15, 2)->default(0);

            // نسبة الضريبة
            $table->decimal('tax_percent', 8, 2)->default(0);

            // قيمة الضريبة
            $table->decimal('tax_value', 15, 2)->default(0);

            // ملاحظات
            $table->text('notes')->nullable();

            // إجمالي الفاتورة
            $table->decimal('total_cost', 15, 2)->default(0);

            // رقم الحساب المالي
            $table->unsignedBigInteger('account_number')->nullable();

            // المبلغ على الحساب
            $table->decimal('money_for_account', 15, 2)->default(0);

            // نوع الفاتورة / الدفع
            $table->tinyInteger('bill_type')->nullable();

            // المبلغ المدفوع
            $table->decimal('what_paid', 15, 2)->default(0);

            // المبلغ المتبقي
            $table->decimal('what_remain', 15, 2)->default(0);

            // حركة الخزينة
            $table->unsignedBigInteger('treasury_transaction_id')->nullable();

            // رصيد العميل قبل الفاتورة
            $table->decimal('customer_balance_before', 15, 2)->default(0);

            // رصيد العميل بعد الفاتورة
            $table->decimal('customer_balance_after', 15, 2)->default(0);

            // الشركة
            $table->string('com_code')->nullable();

            // المستخدم الذي أضاف
            $table->unsignedBigInteger('added_by')->nullable();

            // المستخدم الذي عدل
            $table->unsignedBigInteger('updated_by')->nullable();

            // المستخدم الذي اعتمد
            $table->unsignedBigInteger('approved_by')->nullable();


             $table->comment('مرتجع مبيعات');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_return');
    }
};

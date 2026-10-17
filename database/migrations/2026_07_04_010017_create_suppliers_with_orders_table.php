<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // جدول المشتريات ومرتجعات الموردين
    public function up(): void
    {
        Schema::create('suppliers_with_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_type')->nullable();

            $table->bigInteger('auto_serial')->nullable();
            $table->bigInteger('doc_no')->nullable();

            $table->date('order_date')->nullable();

            // FK المورد
            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->onDelete('cascade');

            $table->boolean('is_approved')->default(false);

            $table->decimal('total_before_discount', 15, 2)->nullable();

            $table->tinyInteger('discount_type')->nullable();
            $table->decimal('discount_value', 15, 2)->nullable();

            $table->decimal('tax_percent', 8, 2)->nullable();
            $table->decimal('tax_value', 15, 2)->nullable();

            $table->string('notes')->nullable();

            $table->decimal('total_cost', 15, 2)->nullable();

            $table->bigInteger('account_number')->nullable();
            $table->decimal('money_for_account', 15, 2)->nullable();

            $table->tinyInteger('bill_type')->nullable();

            $table->decimal('what_paid', 15, 2)->nullable();
            $table->decimal('what_remain', 15, 2)->nullable();

            // خزينة
            $table->foreignId('treasury_transaction_id')
                ->nullable()
                ->constrained('treasuries')
                ->nullOnDelete();

            $table->decimal('supplier_balance_before', 15, 2)->nullable();
            $table->decimal('supplier_balance_after', 15, 2)->nullable();

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
        Schema::dropIfExists('suppliers_with_orders');
    }
};

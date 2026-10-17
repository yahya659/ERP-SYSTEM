<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *جدول حركه نقديه للشفتات
     */
    public function up(): void
    {
        Schema::create('treasuries_transactions', function (Blueprint $table) {
            $table->id();
              // الخزينة
            $table->foreignId('treasuries_id')
                ->constrained('treasuries')
                ->cascadeOnDelete();

            // نوع الحركة النقدية
            $table->integer('mov_type');

            // كود الحركة في الجدول المرتبط
            $table->unsignedBigInteger('the_forign_key')
                ->nullable();

           // رقم الحساب المالي - ID من جدول accauonts
            $table->unsignedBigInteger('accauont_number')
                ->nullable();

            $table->foreign('accauont_number')
                ->references('id')
                ->on('accauonts')
                ->nullOnDelete();

            // هل الحركة مرتبطة بحساب مالي؟
            $table->tinyInteger('is_accauont')
                ->default(1);

            // هل الحركة معتمدة؟
            $table->tinyInteger('is_Approved')
                ->default(1);

            // شفت المستخدم
            $table->unsignedBigInteger('admin_shift_id');

            $table->foreign('admin_shift_id')
                ->references('id')
                ->on('admins_shift')
                ->cascadeOnDelete();

            // المبلغ المصروف أو المحصل من الخزينة
            $table->decimal('money', 10, 2)
                ->default(0);

            // المبلغ المستحق للحساب أو على الحساب
            $table->decimal('money_for_accauont', 10, 2)
                ->default(0);

            // البيان
            $table->string('bayan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries_transactions');
    }
};

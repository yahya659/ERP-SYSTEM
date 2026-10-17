<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جدول الشفتات.
     */
    public function up(): void
    {
        Schema::create('admins_shift', function (Blueprint $table) {

          $table->id();
            // المستخدم صاحب الشفت
            $table->unsignedBigInteger('admin_id');

            // الخزنه
            $table->unsignedBigInteger('treasuries_id');


            // تاريخ بداية الوردية
            $table->dateTime('start_date')->nullable();

            // تاريخ نهاية الوردية
            $table->dateTime('end_date')->nullable();

            // رصيد الخزنه في اول الشفت
           
            $table->decimal('treasuries_balance_in_shift_start', 14, 2)->default(0);

            // هل انتهى الشفت
            $table->tinyInteger('is_finished')->default(1);

            // هل تم التسليم والمراجعه
            $table->tinyInteger('is_delivered_and_rivew')->default(0);

            // من الذي استلم
            $table->integer('delivered_to_admin_id')->nullable();

            // الشفت الذي تم التسليم له
            $table->unsignedBigInteger('delivered_admin_to_shift_id')->nullable();

            // تم تسليمه الى اي خزنه
            $table->unsignedBigInteger('delivered_to_treasuries_id')->nullable();

            // النقديه المفروض تسليمها
            $table->decimal('mony_should_delivered', 14, 2)->default(0);

            // النقديه الفعليه التي تم تسليمها
            $table->decimal('what_realy_delivered', 14, 2)->default(0);

            // حالة النقديه
            // 1 مسلم - 0 عجز - 2 زياده
            $table->tinyInteger('mony_state')->default(1);

            // قيمة العجز او الزياده
            $table->decimal('mony_state_value', 14, 2)->default(0);

            // نوع الاستلام
            // 1 نفس الخزنه - 2 خزنه اخرى
            $table->tinyInteger('reseave_type')->default(1);

            // تاريخ مراجعة واستلام الشفت
            $table->dateTime('review_reseave_date')->nullable();

            // ملاحظات
            $table->text('nods')->nullable();


            // بيانات النظام
            $table->string('com_code')->nullable();

            $table->unsignedBigInteger('added_by')->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();


            // العلاقات

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->cascadeOnDelete();


            $table->foreign('treasuries_id')
                ->references('id')
                ->on('treasuries')
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins_shift');
    }
};

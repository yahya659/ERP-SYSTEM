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
        // جدول الخزن
        Schema::create('treasuries', function (Blueprint $table) {
             $table->id();

            $table->string('name');//اسم الخزن

            $table->tinyInteger('is_master')->default(0);//هل الخزن رءيسيه

            $table->decimal('last_isal_exchange', 14, 2)->default(0);//رقم اخر ايصال صرف

            $table->decimal('last_isal_collection', 14, 2)->default(0);//رقم اخر ايصال تحصيل

            $table->unsignedBigInteger('added_by')->nullable();//المستخدم الذي اضيف الخزن

            $table->unsignedBigInteger('updated_by')->nullable();//المستخدم الذي اخر تحديث الخزن

            $table->string('com_code')->nullable();//كود الشركة
            $table->tinyInteger('active')->default(1);//حالة الخزن

            $table->date('date')->nullable();//تاريخ اضافة الخزن

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries');
    }
};

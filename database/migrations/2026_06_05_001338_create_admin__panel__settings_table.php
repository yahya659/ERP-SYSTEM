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
        Schema::create('admin__panel__settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');//اسم الشركة
            $table->tinyInteger('active')->default(1);//حالة الشركة
            $table->text('general_alert')->nullable();//رسالة تنبيه أعلى الشاشة
            $table->string('address')->nullable();//عنوان الشركة
            $table->string('phone')->nullable();//رقم الهاتف
            $table->unsignedBigInteger('added_by')->nullable();//المستخدم الذي اضيف الاعدادات
            $table->unsignedBigInteger('updated_by')->nullable();//المستخدم الذي اخر تحديث للاعدادات
            $table->string('com_code')->nullable();//كود الشركة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin__panel__settings');
    }
};

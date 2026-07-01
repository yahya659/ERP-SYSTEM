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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');//اسم المستخدم
            $table->string('email')->unique();//الايميل
            $table->string('username')->unique();//اسم المستخدم لتسجيل الدخول
            $table->string('password');
            $table->unsignedBigInteger('added_by')->nullable();//لتسجيل من هو المستخدم الذي اضيف الادمن
            $table->unsignedBigInteger('updated_by')->nullable();//لتسجيل من هو المستخدم الذي اخر تحديث للادمن
            $table->string('com_code')->nullable();//كود الشركة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

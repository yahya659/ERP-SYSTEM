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
        // جدول تسليم المخزن
        Schema::create('treasuries_delivery', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('treasuries_id');//الخزنه التي سوف تستلمها
        $table->unsignedBigInteger('treasuries_can_delivery_id');//الخزنه الذي سيتم تسليمها
        $table->unsignedBigInteger('added_by')->nullable();//من الذي اضافها
        $table->unsignedBigInteger('updated_by')->nullable();//من الذي حدثها
        $table->unsignedBigInteger('com_code');//
          // العلاقات
        $table->foreign('treasuries_id')->references('id')->on('treasuries')->onDelete('cascade');
        $table->foreign('treasuries_can_delivery_id')->references('id')->on('treasuries')->onDelete('cascade');
        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries_delivery');
    }
};

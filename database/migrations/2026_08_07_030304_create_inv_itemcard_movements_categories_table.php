<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.ا
     * جدول الفئه الريسيه لحركه الصنف
     */
    public function up(): void
    {
        Schema::create('inv_itemcard_movements_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم نوع الحركة

              $table->unsignedBigInteger('added_by')->nullable();
             $table->unsignedBigInteger('updated_by')->nullable();
             $table->integer('com_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_itemcard_movements_categories');
    }
};

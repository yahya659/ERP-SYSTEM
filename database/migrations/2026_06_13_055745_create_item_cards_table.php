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
        // جدول الااصناف
    Schema::create('item_cards', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // اسم الصنف
    $table->tinyInteger('item_type')->default(1);// 1 مخزني - 2 استهلاكي - 3 عهدة
    $table->unsignedBigInteger('inv_itemscard_categories_id');// الفئة
    $table->unsignedBigInteger('parent_inv_itemscard_id')->nullable();// الصنف الأب (في حالة التجزئة)
    $table->tinyInteger('dose_has_retailunit')->default(1);// هل الصنف له وحده تجزئة
    $table->string('retail_uom')->nullable();// وحدة التجزئة (مثلاً حبة).....اسم التجزئه..كود وحده التجزئه
    $table->unsignedBigInteger('uom_id');// وحدة الصنف الأساسية
    $table->decimal('retail_uom_quantity_to_parent',10,2)->default(1);// كمية التجزئة بالنسبة للأب
    $table->unsignedBigInteger('added_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->integer('com_code');
    $table->boolean('active')->default(1);
    $table->date('date')->nullable();
    $table->bigInteger('item_code');// كود الصنف الداخلي
    $table->string('barcode')->nullable();// الباركود
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_cards');
    }
};

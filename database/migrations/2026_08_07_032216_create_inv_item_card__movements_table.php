<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * ججدول الحركات
     */
    public function up(): void
    {
        Schema::create('inv_itemcard_movements', function (Blueprint $table) {

    $table->id();
    // رقم تسلسلي للحركة


    $table->unsignedBigInteger('inv_itemcard_movements_categories');
    // تصنيف الحركة (شراء، بيع، تحويل، جرد...)


    $table->string('item_code');
    // كود الصنف الذي تمت عليه الحركة


    $table->unsignedBigInteger('items_movements_types');
    // نوع الحركة (إضافة، صرف، مرتجع...)


    $table->string('FK_table')->nullable();
    // اسم الجدول المرتبط بالحركة مثل:
    // suppliers_with_orders أو sales_invoices


    $table->string('FK_table_details')->nullable();
    // رقم السجل التفصيلي المرتبط بالحركة
    // مثل رقم تفاصيل الفاتورة


    $table->string('byan')->nullable();
    // بيان أو وصف الحركة
    // مثال: شراء من المورد أحمد


    $table->decimal('quantity_befor_movement',10,2)->default(0);
    // كمية الصنف قبل تنفيذ الحركة


    $table->decimal('quantity_after_move',10,2)->default(0);
    // كمية الصنف بعد تنفيذ الحركة


    $table->unsignedBigInteger('added_by');
    // المستخدم الذي قام بإنشاء الحركة


    $table->date('date');
    // تاريخ حدوث الحركة


    $table->string('com_code');
    // كود الشركة أو المؤسسة


    $table->unsignedBigInteger('store_id');
    // المخزن الذي حدثت فيه الحركة


    $table->decimal('quantity_befor_move_store',10,2)->default(0);
    // رصيد المخزن قبل الحركة


    $table->decimal('quantity_after_move_store',10,2)->default(0);
    // رصيد المخزن بعد الحركة


    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_item_card__movements');
    }
};

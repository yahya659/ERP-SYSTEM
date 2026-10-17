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
        Schema::table('sales_invoice', function (Blueprint $table) {
            //
              // هل الفاتورة مرتبطة بعميل؟
        // 1 = نعم
        // 0 = لا
        $table->tinyInteger('is_has_customer')
            ->default(0)
            ->after('customer_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_invoice', function (Blueprint $table) {
            //
        });
    }
};

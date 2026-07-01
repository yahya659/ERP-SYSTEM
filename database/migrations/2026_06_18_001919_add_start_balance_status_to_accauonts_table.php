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
        Schema::table('accauonts', function (Blueprint $table) {
            //
             $table->tinyInteger('start_balance_status')->default(0);//اختياؤ حاله الحساب اذا مدين او داين او متزن
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accauonts', function (Blueprint $table) {
            //
        });
    }
};

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
        // جدول الشجره المحاسبيه العامه
        Schema::create('accauonts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('accauont_types');
            $table->bigInteger('parient_accauont_number');
            $table->bigInteger('accauont_number');
            $table->decimal('start_balance',10,2);//الحساب الاابتدائي>>>دائن مدين متزن المده
            $table->decimal('current_balance',10,2);
            $table->bigInteger('other_table_fk');
            $table->string('nodes');//ملاحضه
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_archived')->default(1);//هل تم ارشفته
            $table->integer('com_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accauont');
    }
};

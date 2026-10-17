<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جدول المناديب.
     */
    public function up(): void
    {
        Schema::create('delegates', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('phone')->nullable();
            $table->integer('accauont_types');
            $table->bigInteger('delegate_code');
            $table->integer('city_id')->nullable();
            $table->text('address')->nullable();
            $table->decimal('start_balance',10,2);
            $table->decimal('current_balance',10,2);
             $table->string('nodes');//ملاحضه
             $table->unsignedBigInteger('added_by')->nullable();
             $table->unsignedBigInteger('updated_by')->nullable();
             $table->integer('com_code');
             $table->date('date')->nullable();
             $table->boolean('active')->default(1);
              $table->tinyInteger('start_balance_status')->default(0);

              $table->tinyInteger('parcent_type')->default(1)
                 ->comment('نوع العمولة');

                $table->decimal('parcent_sales_commission_jomla', 5, 2)
                    ->default(0)
                    ->comment('نسبة المندوب من مبيعات الجملة');

                $table->decimal('parcent_collection_commission', 5, 2)
                    ->default(0)
                    ->comment('نسبة المندوب من تحصيل الفواتير');

                $table->decimal('parcent_sales_commission_katai', 5, 2)
                    ->default(0)
                    ->comment('نسبة المندوب من المبيعات القطاعي');

                $table->decimal('parcent_sales_commission_nosjamla', 5, 2)
                    ->default(0)
                    ->comment('نسبة المندوب من مبيعات نصف الجملة');
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegates');
    }
};

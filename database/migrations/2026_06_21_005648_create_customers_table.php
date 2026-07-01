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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->integer('accauont_types');
            $table->bigInteger('customer_code');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

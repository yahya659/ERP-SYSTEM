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
        Schema::table('inv_item_batches', function (Blueprint $table) {
            //
              $table->unsignedBigInteger('added_by')->nullable();
             $table->unsignedBigInteger('updated_by')->nullable();
             $table->integer('com_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_item_batches', function (Blueprint $table) {
            //
        });
    }
};

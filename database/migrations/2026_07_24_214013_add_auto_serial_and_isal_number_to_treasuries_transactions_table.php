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
        Schema::table('treasuries_transactions', function (Blueprint $table) {
          $table->bigInteger('auto_serial')->nullable()->after('id');
    $table->bigInteger('isal_number')->nullable()->after('auto_serial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treasuries_transactions', function (Blueprint $table) {
            //
        });
    }
};

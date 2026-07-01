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

        $table->boolean('is_parent')->default(0)->after('name');
        $table->date('date')->nullable()->after('is_parent');
    });
}


public function down(): void
{
    Schema::table('accauonts', function (Blueprint $table) {

        $table->dropColumn([
            'is_parent',
            'date'
        ]);

    });
}
};

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
        Schema::table('admin__panel__settings', function (Blueprint $table) {
            $table->unsignedBigInteger('delegates_parent_number')
                ->nullable()
                ->after('supplier_parent_number');

            $table->unsignedBigInteger('employees_parent_number')
                ->nullable()
                ->after('delegates_parent_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin__panel__settings', function (Blueprint $table) {
            //
        });
    }
};

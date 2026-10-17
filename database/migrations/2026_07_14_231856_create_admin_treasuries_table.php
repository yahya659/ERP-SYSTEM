<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جدول صلاحيات خزن المستخدمين الخاصه.
     */
    public function up(): void
    {
        Schema::create('admin_treasuries', function (Blueprint $table) {
    $table->id();

    $table->foreignId('admin_id')
        ->constrained('admins')
        ->cascadeOnDelete();

    $table->foreignId('treasuries_id')
        ->constrained('treasuries')
        ->cascadeOnDelete();

    $table->tinyInteger('active')->default(1);
    $table->date('date')->nullable();

    $table->unsignedBigInteger('added_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();

    $table->integer('com_code');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_treasuries');
    }
};

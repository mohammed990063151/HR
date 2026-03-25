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
        Schema::create('user_permissions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('permission_name');
    $table->enum('read', ['Y','N'])->default('N');
    $table->enum('write', ['Y','N'])->default('N');
    $table->enum('create', ['Y','N'])->default('N');
    $table->enum('delete', ['Y','N'])->default('N');
    $table->enum('import', ['Y','N'])->default('N');
    $table->enum('export', ['Y','N'])->default('N');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};

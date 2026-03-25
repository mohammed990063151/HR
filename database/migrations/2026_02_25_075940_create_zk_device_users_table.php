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
       Schema::create('zk_device_users', function (Blueprint $table) {
    $table->id();

    $table->string('device_ip', 45)->index();

    // بيانات المستخدم من الجهاز
    $table->string('uid')->nullable()->index();      // uid داخل الجهاز
    $table->string('user_id')->nullable()->index();  // id/employee code
    $table->string('name')->nullable();
    $table->string('role')->nullable();
    $table->string('password')->nullable();

    $table->timestamps();

    // منع تكرار نفس المستخدم لنفس الجهاز
    $table->unique(['device_ip', 'uid']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zk_device_users');
    }
};

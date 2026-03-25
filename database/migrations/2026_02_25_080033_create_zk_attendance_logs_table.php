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
      Schema::create('zk_attendance_logs', function (Blueprint $table) {
    $table->id();

    $table->string('device_ip', 45)->index();

    $table->string('uid')->nullable()->index();       // uid داخل الجهاز
    $table->string('user_id')->nullable()->index();   // employee/device user id

    $table->string('state')->nullable();              // state/status من الجهاز
    $table->timestamp('timestamp')->index();          // وقت البصمة

    $table->timestamps();

    // منع تكرار نفس السجل
    $table->unique(['device_ip', 'uid', 'timestamp']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zk_attendance_logs');
    }
};

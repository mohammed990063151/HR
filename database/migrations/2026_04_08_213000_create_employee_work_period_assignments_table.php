<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('employee_work_period_assignments')) {
            Schema::create('employee_work_period_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
                $table->foreignId('work_period_id')->constrained('work_periods')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['employee_id', 'work_period_id'], 'uniq_employee_work_period');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_work_period_assignments');
    }
};

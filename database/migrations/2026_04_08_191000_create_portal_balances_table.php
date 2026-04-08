<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('portal_balances')) {
            Schema::create('portal_balances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
                $table->unsignedTinyInteger('month');
                $table->unsignedSmallInteger('year');
                $table->unsignedInteger('deserved_balance')->default(0);
                $table->unsignedInteger('remaining_balance')->default(0);
                $table->unsignedInteger('incomplete_records')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['employee_id', 'month', 'year']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_balances');
    }
};

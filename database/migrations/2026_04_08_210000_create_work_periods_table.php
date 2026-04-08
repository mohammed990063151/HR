<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('work_periods')) {
            Schema::create('work_periods', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->time('from_time');
                $table->time('to_time');
                $table->string('type', 20)->default('morning');
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('work_periods');
    }
};

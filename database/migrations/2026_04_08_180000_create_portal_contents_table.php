<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('portal_contents')) {
            Schema::create('portal_contents', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['announcement', 'occasion']);
                $table->string('title');
                $table->text('body')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_contents');
    }
};

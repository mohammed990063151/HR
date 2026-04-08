<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('employee_locations')) {
            Schema::create('employee_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('latitude', 10, 7);
                $table->decimal('longitude', 10, 7);
                $table->decimal('radius_meters', 12, 2)->default(100);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('employee_location_assignments')) {
            Schema::create('employee_location_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
                $table->foreignId('location_id')->constrained('employee_locations')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['employee_id', 'location_id']);
            });
        }

        if (! Schema::hasTable('attendance')) {
            Schema::create('attendance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
                $table->date('date');
                $table->timestamp('check_in')->nullable();
                $table->timestamp('check_out')->nullable();
                $table->decimal('check_in_lat', 10, 7)->nullable();
                $table->decimal('check_in_lng', 10, 7)->nullable();
                $table->decimal('check_out_lat', 10, 7)->nullable();
                $table->decimal('check_out_lng', 10, 7)->nullable();
                $table->string('check_in_ip', 45)->nullable();
                $table->string('check_out_ip', 45)->nullable();
                $table->enum('status', ['present', 'late', 'absent'])->default('present');
                $table->decimal('working_hours', 8, 2)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['employee_id', 'date']);
            });
        }

        if (! Schema::hasTable('employee_requests')) {
            Schema::create('employee_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
                $table->string('type', 32);
                $table->date('date');
                $table->time('from_time')->nullable();
                $table->time('to_time')->nullable();
                $table->text('reason');
                $table->string('status', 32)->default('pending');
                $table->text('admin_note')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_requests');
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('employee_location_assignments');
        Schema::dropIfExists('employee_locations');
    }
};

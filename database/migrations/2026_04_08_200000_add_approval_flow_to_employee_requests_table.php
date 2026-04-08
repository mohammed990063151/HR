<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('employee_requests', 'approval_chain')) {
                $table->json('approval_chain')->nullable()->after('admin_note');
            }
            if (! Schema::hasColumn('employee_requests', 'approval_step')) {
                $table->unsignedInteger('approval_step')->default(0)->after('approval_chain');
            }
            if (! Schema::hasColumn('employee_requests', 'current_approver_employee_id')) {
                $table->foreignId('current_approver_employee_id')
                    ->nullable()
                    ->after('approval_step')
                    ->constrained('employees')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('employee_requests', function (Blueprint $table) {
            if (Schema::hasColumn('employee_requests', 'current_approver_employee_id')) {
                $table->dropConstrainedForeignId('current_approver_employee_id');
            }
            if (Schema::hasColumn('employee_requests', 'approval_step')) {
                $table->dropColumn('approval_step');
            }
            if (Schema::hasColumn('employee_requests', 'approval_chain')) {
                $table->dropColumn('approval_chain');
            }
        });
    }
};

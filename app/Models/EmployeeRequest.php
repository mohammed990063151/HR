<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'date',
        'from_time',
        'to_time',
        'reason',
        'status',
        'admin_note',
        'approval_chain',
        'approval_step',
        'current_approver_employee_id',
    ];

    protected $casts = [
        'date' => 'date',
        'approval_chain' => 'array',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function currentApprover(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'current_approver_employee_id');
    }

    public function typeLabel(): string
    {
        $dynamic = RequestType::query()->where('code', $this->type)->value('name');
        if ($dynamic) {
            return $dynamic;
        }

        return match ($this->type) {
            'permission' => 'استئذان',
            'late' => 'تأخير',
            'absence' => 'غياب',
            'correction' => 'طلب تصحيح',
            default => $this->type,
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'قيد المراجعة',
            'approved' => 'موافق',
            'rejected' => 'مرفوض',
            default => $this->status,
        };
    }

    public function waitingAtLabel(): string
    {
        if ($this->status !== 'pending') {
            return $this->status === 'approved' ? 'تمت الموافقة النهائية' : ($this->status === 'rejected' ? 'تم رفض الطلب' : '—');
        }

        return $this->currentApprover?->name
            ? "بانتظار {$this->currentApprover->name}"
            : 'بانتظار الإدارة';
    }
}

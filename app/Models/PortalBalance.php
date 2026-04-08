<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalBalance extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'deserved_balance',
        'remaining_balance',
        'incomplete_records',
        'notes',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}

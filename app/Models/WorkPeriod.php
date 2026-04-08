<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkPeriod extends Model
{
    protected $fillable = [
        'title',
        'from_time',
        'to_time',
        'type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(
            Employee::class,
            'employee_work_period_assignments',
            'work_period_id',
            'employee_id'
        )->withTimestamps();
    }
}

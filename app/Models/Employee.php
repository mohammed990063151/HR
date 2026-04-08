<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'birth_date',
        'gender',
        'employee_id',
        'line_manager',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            EmployeeLocation::class,
            'employee_location_assignments',
            'employee_id',
            'location_id'
        )->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(EmployeeRequest::class);
    }

    public function workPeriods(): BelongsToMany
    {
        return $this->belongsToMany(
            WorkPeriod::class,
            'employee_work_period_assignments',
            'employee_id',
            'work_period_id'
        )->withTimestamps();
    }
}

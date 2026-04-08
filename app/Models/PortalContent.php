<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalContent extends Model
{
    protected $fillable = [
        'type',
        'title',
        'body',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
}

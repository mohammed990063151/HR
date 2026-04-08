<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'requires_time',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'requires_time' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}

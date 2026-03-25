<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ZkDeviceUser extends Model
{
    use HasFactory;

    protected $table = 'zk_device_users';

    protected $fillable = [
        'device_ip','uid','user_id','name','role','password'
    ];
}
<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ZkAttendanceLog extends Model
{
    protected $table = 'zk_attendance_logs';

    protected $fillable = [
        'device_ip','uid','user_id','state','timestamp'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

   public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_db_id');
}
}
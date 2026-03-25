<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveInformation;
use App\Models\LeavesAdmin;
use App\Models\Leave;
use DateTime;
use Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\ZkAttendanceLog;
use Carbon\Carbon;
use App\Models\Employee;

class LeavesController extends Controller
{
    /** Leaves Admin Page */
    public function leavesAdmin()
    {
        $userList = DB::table('users')->get();
        $leaveInformation = LeaveInformation::all();
        $getLeave = Leave::all();
        return view('employees.leaves_manage.leavesadmin',compact('leaveInformation','userList','getLeave'));
    }

    /** Get Information Leave */
    public function getInformationLeave(Request $request)
    {
        try {

            $numberOfDay = $request->number_of_day;
            $leaveType   = $request->leave_type;
            $leaveDay = LeaveInformation::where('leave_type', $leaveType)->first();
            
            if ($leaveDay) {
                $days = $leaveDay->leave_days - ($numberOfDay ?? 0);
            } else {
                $days = 0; // Handle case if leave type doesn't exist
            }

            $data = [
                'response_code' => 200,
                'status'        => 'success',
                'message'       => 'Get success',
                'leave_type'    => $days,
                'number_of_day' => $numberOfDay,
            ];
            
            return response()->json($data);

        } catch (\Exception $e) {
            // Log the exception and return an appropriate response
            \Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    /** Apply Leave */
    public function saveRecordLeave(Request $request)
    {
        // Create an instance of the Leave model
        $leave = new Leave();
        // Call the applyLeave method
        return $leave->applyLeave($request);
    }

    /** Delete Record */
    public function deleteLeave(Request $request)
    {
        // Delete an instance of the Leave model
        $delete = new Leave();
        // Call the delete method
        return $delete->deleteRecord($request);
    }

    /** Leave Settings Page */
    public function leaveSettings()
    {
        return view('employees.leaves_manage.leavesettings');
    }

    /** Attendance Admin */
   
// public function AttendanceEmployee(Request $request)
// {
//     $date  = $request->get('date');
//     $month = $request->get('month');
//     $year  = $request->get('year');

//     $baseQuery = DB::table('zk_attendance_logs')
//         ->join('employees', 'employees.employee_id', '=', 'zk_attendance_logs.user_id')
//         ->select([
//             'employees.id          as emp_id',
//             'employees.name        as employee_name',
//             'employees.employee_id as employee_code',
//             DB::raw('DATE(zk_attendance_logs.timestamp) as day_date'),
//             DB::raw('MIN(zk_attendance_logs.timestamp)  as check_in'),
//             DB::raw('MAX(zk_attendance_logs.timestamp)  as check_out'),
//         ])
//         ->whereNotNull('zk_attendance_logs.user_id')
//         ->groupBy(
//             'employees.id',
//             'employees.name',
//             'employees.employee_id',
//             DB::raw('DATE(zk_attendance_logs.timestamp)')
//         )
//         ->orderBy('day_date', 'desc');

//     // ── فلاتر ──────────────────────────────────────────────
//     if ($date) {
//         $baseQuery->whereDate('zk_attendance_logs.timestamp', $date);
//     } else {
//         if ($month) $baseQuery->whereMonth('zk_attendance_logs.timestamp', $month);
//         if ($year)  $baseQuery->whereYear('zk_attendance_logs.timestamp', $year);
//     }

//     // ── الصفحات للجدول ─────────────────────────────────────
//     $rows = (clone $baseQuery)->paginate(50)->withQueryString();

//     // ── إحصائيات منفصلة بـ query مستقل ───────────────────
//     $today      = Carbon::today();
//     $weekStart  = Carbon::now()->startOfWeek();
//     $monthStart = Carbon::now()->startOfMonth();

//     $workMinutesToday = DB::table('zk_attendance_logs')
//         ->join('employees', 'employees.id', '=', 'zk_attendance_logs.user_id')
//         ->whereNotNull('zk_attendance_logs.user_id')
//         ->whereDate('zk_attendance_logs.timestamp', $today)
//         ->selectRaw('
//             TIMESTAMPDIFF(
//                 MINUTE,
//                 MIN(zk_attendance_logs.timestamp),
//                 MAX(zk_attendance_logs.timestamp)
//             ) as mins
//         ')
//         ->groupBy(
//             'employees.id',
//             DB::raw('DATE(zk_attendance_logs.timestamp)')
//         )
//         ->get()
//         ->sum('mins');

//     $workMinutesWeek = DB::table('zk_attendance_logs')
//         ->join('employees', 'employees.id', '=', 'zk_attendance_logs.user_id')
//         ->whereNotNull('zk_attendance_logs.user_id')
//         ->whereBetween('zk_attendance_logs.timestamp', [$weekStart, Carbon::now()])
//         ->selectRaw('
//             TIMESTAMPDIFF(
//                 MINUTE,
//                 MIN(zk_attendance_logs.timestamp),
//                 MAX(zk_attendance_logs.timestamp)
//             ) as mins
//         ')
//         ->groupBy(
//             'employees.id',
//             DB::raw('DATE(zk_attendance_logs.timestamp)')
//         )
//         ->get()
//         ->sum('mins');

//     $workMinutesMonth = DB::table('zk_attendance_logs')
//         ->join('employees', 'employees.id', '=', 'zk_attendance_logs.user_id')
//         ->whereNotNull('zk_attendance_logs.user_id')
//         ->whereBetween('zk_attendance_logs.timestamp', [$monthStart, Carbon::now()])
//         ->selectRaw('
//             TIMESTAMPDIFF(
//                 MINUTE,
//                 MIN(zk_attendance_logs.timestamp),
//                 MAX(zk_attendance_logs.timestamp)
//             ) as mins
//         ')
//         ->groupBy(
//             'employees.id',
//             DB::raw('DATE(zk_attendance_logs.timestamp)')
//         )
//         ->get()
//         ->sum('mins');

//     return view('employees.attendanceemployee', compact(
//         'rows',
//         'workMinutesToday',
//         'workMinutesWeek',
//         'workMinutesMonth'
//     ));
// }

public function AttendanceEmployee(Request $request)
{
    $date  = $request->get('date');
    $month = $request->get('month');
    $year  = $request->get('year');

    $today      = Carbon::today();
    $weekStart  = Carbon::now()->startOfWeek();
    $monthStart = Carbon::now()->startOfMonth();

    // ── جلب أسماء الموظفين كـ lookup ──────────────────────
    $employeesMap = DB::table('employees')
        ->pluck('name', 'employee_id'); // [id => name]

    // ── Base Query بدون JOIN ────────────────────────────────
    $baseQuery = DB::table('zk_attendance_logs')
        ->selectRaw('
            user_id,
            DATE(timestamp) as day_date,
            MIN(timestamp)  as check_in,
            MAX(timestamp)  as check_out,
            COUNT(*)        as punch_count
        ')
        ->whereNotNull('user_id');

    // ── فلاتر ──────────────────────────────────────────────
    if ($date) {
        $baseQuery->whereDate('timestamp', $date);
    } else {
        if ($month) $baseQuery->whereMonth('timestamp', $month);
        if ($year)  $baseQuery->whereYear('timestamp',  $year);
    }

    $baseQuery->groupBy('user_id', DB::raw('DATE(timestamp)'))
              ->orderBy('day_date', 'desc')
              ->orderBy('user_id',  'asc');

    // ── Paginate ────────────────────────────────────────────
    $paginated = $baseQuery->paginate(50)->withQueryString();

    // ── إضافة اسم الموظف لكل صف ───────────────────────────
    $rows = $paginated->through(function ($row) use ($employeesMap) {
        $row->employee_name = $employeesMap->get($row->user_id)
            ?? 'موظف #' . $row->user_id;
        return $row;
    });

    // ── حساب دقائق العمل ───────────────────────────────────
    $calcMinutes = function (string $from, string $to) {
        return DB::table('zk_attendance_logs')
            ->whereNotNull('user_id')
            ->whereBetween('timestamp', [$from, $to])
            ->selectRaw('
                user_id,
                DATE(timestamp) as day_date,
                TIMESTAMPDIFF(MINUTE, MIN(timestamp), MAX(timestamp)) as mins
            ')
            ->groupBy('user_id', DB::raw('DATE(timestamp)'))
            ->get()
            ->sum('mins');
    };

    $workMinutesToday = $calcMinutes(
        $today->toDateString() . ' 00:00:00',
        $today->toDateString() . ' 23:59:59'
    );
    $workMinutesWeek  = $calcMinutes(
        $weekStart->toDateTimeString(),
        Carbon::now()->toDateTimeString()
    );
    $workMinutesMonth = $calcMinutes(
        $monthStart->toDateTimeString(),
        Carbon::now()->toDateTimeString()
    );

    return view('employees.attendanceemployee', compact(
        'rows',
        'workMinutesToday',
        'workMinutesWeek',
        'workMinutesMonth'
    ));
}
public function attendanceModalData(Request $request)
{
    $employeeId = $request->get('employee_id');
    $date       = $request->get('date');

    if (!$employeeId || !$date) {
        return response()->json(['error' => 'بيانات ناقصة'], 422);
    }

    $employee = Employee::select('id', 'name', 'employee_id')->find($employeeId);

    if (!$employee) {
        return response()->json(['error' => 'الموظف غير موجود'], 404);
    }

    $start = Carbon::parse($date)->startOfDay();
    $end   = Carbon::parse($date)->endOfDay();

    $logs = ZkAttendanceLog::where('user_id', $employeeId)
        ->whereBetween('timestamp', [$start, $end])
        ->orderBy('timestamp')
        ->get();

    $checkIn    = null;
    $checkOut   = null;
    $workHours  = null;
    $logsFormatted = [];

    if ($logs->isNotEmpty()) {
        // أول بصمة = دخول
        $firstLog = $logs->first();
        $checkIn  = Carbon::parse($firstLog->timestamp)->format('H:i:s');

        // آخر بصمة = خروج (فقط إذا في أكثر من بصمة)
        if ($logs->count() > 1) {
            $lastLog  = $logs->last();
            $checkOut = Carbon::parse($lastLog->timestamp)->format('H:i:s');

            // حساب ساعات العمل بين أول وآخر بصمة
            $diff      = Carbon::parse($firstLog->timestamp)
                               ->diffInMinutes(Carbon::parse($lastLog->timestamp));
            $workHours = intdiv($diff, 60) . 'h ' . ($diff % 60) . 'm';
        }

        // كل البصمات للعرض
        foreach ($logs as $log) {
            $logsFormatted[] = [
                'time' => Carbon::parse($log->timestamp)->format('H:i:s'),
            ];
        }
    }

    return response()->json([
        'employee'   => $employee,
        'date'       => $date,
        'check_in'   => $checkIn,
        'check_out'  => $checkOut,
        'work_hours' => $workHours,
        'logs'       => $logsFormatted,
    ]);
}
    /** Attendance Employee */
  

public function attendanceModal(Request $request)
{
    $employeeId = $request->get('employee_id'); // employees.employee_id
    $date       = $request->get('date');        // YYYY-MM-DD

    if (!$employeeId || !$date) {
        return response()->json(['message' => 'Missing params'], 422);
    }

    $emp = Employee::where('employee_id', $employeeId)->first();

    $logs = ZkAttendanceLog::query()
        ->where('user_id', $employeeId)
        ->whereDate('timestamp', $date)
        ->orderBy('timestamp')
        ->get(['timestamp', 'state']);

    $checkIn  = $logs->first()?->timestamp;
    $checkOut = $logs->last()?->timestamp;

    $workMinutes = 0;
    if ($checkIn && $checkOut) {
        $workMinutes = Carbon::parse($checkIn)->diffInMinutes(Carbon::parse($checkOut));
    }

    return response()->json([
        'employee' => [
            'name' => $emp?->name ?? 'غير معروف',
            'employee_id' => $employeeId,
        ],
        'date' => $date,
        'check_in' => $checkIn ? Carbon::parse($checkIn)->toDateTimeString() : null,
        'check_out' => $checkOut ? Carbon::parse($checkOut)->toDateTimeString() : null,
        'work_hours' => $workMinutes ? round($workMinutes / 60, 2) : 0,
        'logs' => $logs->map(fn($l) => [
            'time' => Carbon::parse($l->timestamp)->format('h:i A'),
            'timestamp' => Carbon::parse($l->timestamp)->toDateTimeString(),
            'state' => $l->state,
        ])->values(),
    ]);
}




    /** Leaves Employee Page */
    public function leavesEmployee()
    {
        $leaveInformation = LeaveInformation::all();
        $getLeave = Leave::where('staff_id', Session::get('user_id'))->get();

        return view('employees.leaves_manage.leavesemployee',compact('leaveInformation', 'getLeave'));
    }

    /** Shift Scheduling */
    public function shiftScheduLing()
    {
        return view('employees.shiftscheduling');
    }

    /** Shift List */
    public function shiftList()
    {
        return view('employees.shiftlist');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $employeeId = $request->integer('employee_id');
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Attendance::query()
            ->with('employee')
            ->orderByDesc('date')
            ->orderByDesc('check_in');

        if ($employeeId > 0) {
            $query->where('employee_id', $employeeId);
        }

        if (! empty($from)) {
            $query->whereDate('date', '>=', $from);
        }

        if (! empty($to)) {
            $query->whereDate('date', '<=', $to);
        }

        $attendances = $query->paginate(30)->withQueryString();
        $employees = Employee::query()->orderBy('name')->get(['id', 'name', 'employee_id']);

        return view('admin.attendance.index', compact('attendances', 'employees', 'employeeId', 'from', 'to'));
    }

    public function show(Employee $employee, Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $month = max(1, min(12, $request->integer('month', now()->month)));
        $year = max(now()->year - 5, min(now()->year + 1, $request->integer('year', now()->year)));

        $records = Attendance::query()
            ->where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderByDesc('date')
            ->paginate(31)
            ->withQueryString();

        return view('admin.attendance.show', compact('employee', 'records', 'month', 'year'));
    }
}

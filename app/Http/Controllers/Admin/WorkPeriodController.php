<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkPeriod;
use Illuminate\Http\Request;

class WorkPeriodController extends Controller
{
    public function index()
    {
        abort_unless(user_is_admin(), 403);
        $periods = WorkPeriod::query()->with('employees')->orderBy('sort_order')->orderBy('id')->get();
        $employees = Employee::query()->orderBy('name')->get(['id', 'name', 'employee_id']);

        return view('admin.work-periods.index', compact('periods', 'employees'));
    }

    public function store(Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:100',
            'from_time' => 'required|date_format:H:i',
            'to_time' => 'required|date_format:H:i|after:from_time',
            'type' => 'required|in:morning,evening,custom',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        WorkPeriod::create([
            'title' => $data['title'],
            'from_time' => $data['from_time'],
            'to_time' => $data['to_time'],
            'type' => $data['type'],
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return back()->with('success', 'تمت إضافة فترة العمل.');
    }

    public function toggle(WorkPeriod $workPeriod)
    {
        abort_unless(user_is_admin(), 403);
        $workPeriod->update(['is_active' => ! $workPeriod->is_active]);

        return back()->with('success', 'تم تغيير الحالة.');
    }

    public function destroy(WorkPeriod $workPeriod)
    {
        abort_unless(user_is_admin(), 403);
        $workPeriod->delete();

        return back()->with('success', 'تم حذف الفترة.');
    }

    public function assign(Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_period_ids' => 'required|array|min:1',
            'work_period_ids.*' => 'required|exists:work_periods,id',
        ]);

        $employee = Employee::query()->findOrFail((int) $data['employee_id']);
        $employee->workPeriods()->sync(array_map('intval', $data['work_period_ids']));

        return back()->with('success', 'تم ربط فترات العمل بالموظف.');
    }
}

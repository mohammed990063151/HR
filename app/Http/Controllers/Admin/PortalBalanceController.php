<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PortalBalance;
use Illuminate\Http\Request;

class PortalBalanceController extends Controller
{
    public function index()
    {
        abort_unless(user_is_admin(), 403);

        $employees = Employee::query()->orderBy('name')->get(['id', 'name', 'employee_id']);
        $balances = PortalBalance::query()->with('employee')->orderByDesc('year')->orderByDesc('month')->paginate(20);

        return view('admin.portal-balances.index', compact('employees', 'balances'));
    }

    public function store(Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
            'deserved_balance' => 'required|integer|min:0',
            'remaining_balance' => 'required|integer|min:0',
            'incomplete_records' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:2000',
        ]);

        PortalBalance::updateOrCreate(
            [
                'employee_id' => $data['employee_id'],
                'month' => $data['month'],
                'year' => $data['year'],
            ],
            [
                'deserved_balance' => $data['deserved_balance'],
                'remaining_balance' => $data['remaining_balance'],
                'incomplete_records' => $data['incomplete_records'],
                'notes' => $data['notes'] ?? null,
            ]
        );

        return back()->with('success', 'تم حفظ رصيد الموظف بنجاح.');
    }

    public function destroy(PortalBalance $portalBalance)
    {
        abort_unless(user_is_admin(), 403);
        $portalBalance->delete();

        return back()->with('success', 'تم حذف السجل.');
    }
}

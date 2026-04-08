<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeRequestController extends Controller
{
    public function index()
    {
        $currentEmployeeId = Employee::query()
            ->where('user_id', (int) auth()->id())
            ->value('id');

        $requests = EmployeeRequest::query()
            ->with(['employee', 'currentApprover'])
            ->when($currentEmployeeId, function ($q) use ($currentEmployeeId) {
                $q->where(function ($inner) use ($currentEmployeeId) {
                    $inner->where('current_approver_employee_id', $currentEmployeeId)
                        ->orWhere(function ($done) use ($currentEmployeeId) {
                            $done->whereIn('status', ['approved', 'rejected'])
                                ->whereJsonContains('approval_chain', $currentEmployeeId);
                        });
                });
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.requests.index', compact('requests'));
    }

    public function review(Request $request, EmployeeRequest $employeeRequest)
    {
        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:2000',
        ]);

        $currentEmployeeId = Employee::query()
            ->where('user_id', (int) auth()->id())
            ->value('id');

        if (
            $employeeRequest->status === 'pending'
            && $employeeRequest->current_approver_employee_id
            && $currentEmployeeId
            && (int) $employeeRequest->current_approver_employee_id !== (int) $currentEmployeeId
        ) {
            abort(403, 'لا يمكنك اعتماد هذا الطلب الآن.');
        }

        $approverName = Employee::query()->whereKey($currentEmployeeId)->value('name') ?? 'المدير';
        $stamp = Carbon::now()->format('Y-m-d H:i');
        $baseNote = trim((string) ($employeeRequest->admin_note ?? ''));

        if ($data['status'] === 'rejected') {
            $employeeRequest->update([
                'status' => 'rejected',
                'current_approver_employee_id' => null,
                'admin_note' => trim(implode("\n", array_filter([
                    $baseNote,
                    $data['admin_note'] ?? null,
                    "تم رفض الطلب بواسطة {$approverName} بتاريخ {$stamp}.",
                ]))),
            ]);

            return back()->with('success', 'تم رفض الطلب.');
        }

        $chain = (array) ($employeeRequest->approval_chain ?? []);
        $nextStep = ((int) $employeeRequest->approval_step) + 1;
        $nextApproverId = $chain[$nextStep] ?? null;

        if ($nextApproverId) {
            $nextApproverName = Employee::query()->whereKey($nextApproverId)->value('name') ?? 'المدير التالي';
            $employeeRequest->update([
                'status' => 'pending',
                'approval_step' => $nextStep,
                'current_approver_employee_id' => $nextApproverId,
                'admin_note' => trim(implode("\n", array_filter([
                    $baseNote,
                    $data['admin_note'] ?? null,
                    "تمت الموافقة من {$approverName} بتاريخ {$stamp}.",
                    "تم تحويل الطلب إلى {$nextApproverName}.",
                ]))),
            ]);

            return back()->with('success', 'تمت الموافقة وإرسال الطلب للمدير الأعلى.');
        }

        $employeeRequest->update([
            'status' => 'approved',
            'current_approver_employee_id' => null,
            'admin_note' => trim(implode("\n", array_filter([
                $baseNote,
                $data['admin_note'] ?? null,
                "تمت الموافقة النهائية من {$approverName} بتاريخ {$stamp}.",
            ]))),
        ]);

        return back()->with('success', 'تم تحديث الطلب.');
    }
}

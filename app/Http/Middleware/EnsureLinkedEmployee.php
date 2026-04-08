<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class EnsureLinkedEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $employee = $this->resolveEmployee($user);

        if (! $employee) {
            abort(Response::HTTP_FORBIDDEN, 'لا يوجد سجل موظف مرتبط بحسابك. تأكد من ربط حسابك بسجل موظف، أو أن رقم الموظف (employee_id) يطابق معرف المستخدم (user_id)، أو أن البريد الإلكتروني متطابق بين الحساب وسجل الموظف.');
        }

        $request->attributes->set('employee_id', (int) $employee->id);

        return $next($request);
    }

    /**
     * 1) employees.user_id = users.id
     * 2) employees.employee_id = users.user_id (مثل KH-0001)
     * 3) نفس البريد الإلكتروني
     */
    private function resolveEmployee(User $user): ?Employee
    {
        if (Schema::hasColumn('employees', 'user_id')) {
            $byFk = Employee::query()->where('user_id', $user->id)->first();
            if ($byFk) {
                return $byFk;
            }
        }

        if (! empty($user->user_id)) {
            $byCode = Employee::query()->where('employee_id', $user->user_id)->first();
            if ($byCode) {
                $this->backfillUserId($byCode, $user);

                return $byCode;
            }
        }

        if (! empty($user->email)) {
            $email = mb_strtolower(trim($user->email));
            $byEmail = Employee::query()
                ->whereRaw('LOWER(TRIM(email)) = ?', [$email])
                ->first();
            if ($byEmail) {
                $this->backfillUserId($byEmail, $user);

                return $byEmail;
            }
        }

        return null;
    }

    private function backfillUserId(Employee $employee, User $user): void
    {
        if (! Schema::hasColumn('employees', 'user_id')) {
            return;
        }
        if ($employee->user_id === null || (int) $employee->user_id !== (int) $user->id) {
            $employee->forceFill(['user_id' => $user->id])->saveQuietly();
        }
    }
    
}

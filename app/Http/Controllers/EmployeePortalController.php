<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeRequest;
use App\Models\RequestType;
use App\Models\PortalBalance;
use App\Models\PortalContent;
use App\Models\WorkPeriod;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeePortalController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService
    ) {}

    public function index(Request $request)
    {
        $employeeId = (int) $request->attributes->get('employee_id');

        $todayRecord = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', today())
            ->first();

        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        $stats = $this->attendanceService->monthStats($employeeId, $monthStart, $monthEnd);

        $requests = EmployeeRequest::where('employee_id', $employeeId)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $requestTypes = RequestType::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);
        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderByDesc('date')
            ->get();

        $employeeName = DB::table('employees')
            ->where('id', $employeeId)
            ->value('name') ?? 'الموظف';

        $role = $request->user()->role_name ?? '';
        $showAdminNav = $role === 'Admin'
            || str_contains(strtolower((string) $role), 'admin');

        $serverEnforcesGeo = (bool) config('attendance.require_geolocation', false);

        $adminBalance = PortalBalance::query()
            ->where('employee_id', $employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($adminBalance) {
            $stats->deserved_balance = (int) $adminBalance->deserved_balance;
            $stats->remaining_balance = (int) $adminBalance->remaining_balance;
            $stats->incomplete_days = (int) $adminBalance->incomplete_records;
        }

        $announcements = PortalContent::query()
            ->where('type', 'announcement')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', today());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', today());
            })
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $weeklyOccasions = PortalContent::query()
            ->where('type', 'occasion')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', today()->addDays(7));
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', today()->subDays(1));
            })
            ->orderBy('start_date')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $workPeriods = WorkPeriod::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(2)
            ->get();

        $employeePeriods = Employee::query()
            ->with(['workPeriods' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
            }])
            ->find($employeeId)
            ?->workPeriods
            ?->take(2);

        if ($employeePeriods && $employeePeriods->isNotEmpty()) {
            $workPeriods = $employeePeriods;
        }

        $todayReport = Attendance::query()
            ->where('employee_id', $employeeId)
            ->whereDate('date', today())
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN check_in IS NOT NULL AND check_out IS NULL THEN 1 ELSE 0 END) as incomplete')
            ->first();

        $weekReport = Attendance::query()
            ->where('employee_id', $employeeId)
            ->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent, SUM(CASE WHEN check_in IS NOT NULL AND check_out IS NULL THEN 1 ELSE 0 END) as incomplete')
            ->first();

        return view('front.employees.portal', compact(
            'todayRecord',
            'stats',
            'requests',
            'requestTypes',
            'attendance',
            'employeeName',
            'month',
            'year',
            'showAdminNav',
            'serverEnforcesGeo',
            'announcements',
            'weeklyOccasions',
            'workPeriods',
            'todayReport',
            'weekReport',
        ));
    }

    public function requestsPage(Request $request)
    {
        $employeeId = (int) $request->attributes->get('employee_id');
        $status = (string) $request->get('status', '');
        $type = (string) $request->get('type', '');
        $sort = (string) $request->get('sort', 'newest');

        $query = EmployeeRequest::query()->where('employee_id', $employeeId);

        if ($status !== '') {
            $query->where('status', $status);
        }
        if ($type !== '') {
            $query->where('type', $type);
        }

        $sort === 'oldest'
            ? $query->orderBy('created_at')
            : $query->orderByDesc('created_at');

        $requests = $query->paginate(10)->withQueryString();

        $requestTypes = RequestType::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('front.employees.requests', compact(
            'requests',
            'requestTypes',
            'status',
            'type',
            'sort'
        ));
    }

    public function attendanceBoard(Request $request)
    {
        $employeeId = (int) $request->attributes->get('employee_id');
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);
        $day = (int) $request->get('day', now()->day);

        $monthStart = Carbon::create($year, $month, 1)->startOfDay();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $selectedDate = Carbon::create($year, $month, min(max($day, 1), $monthEnd->day))->toDateString();

        $records = Attendance::query()
            ->where('employee_id', $employeeId)
            ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->orderBy('date')
            ->get();

        $recordsByDate = $records->keyBy(fn ($r) => optional($r->date)->format('Y-m-d'));
        $selectedRecord = $recordsByDate->get($selectedDate);

        $employeeName = DB::table('employees')
            ->where('id', $employeeId)
            ->value('name') ?? 'الموظف';

        return view('front.employees.attendance-board', compact(
            'employeeName',
            'month',
            'year',
            'day',
            'monthStart',
            'monthEnd',
            'records',
            'recordsByDate',
            'selectedDate',
            'selectedRecord'
        ));
    }

    public function checkIn(Request $request)
    {
        $requireGeo = (bool) config('attendance.require_geolocation', false);
        $validated = $request->validate([
            'latitude' => ($requireGeo ? 'required' : 'nullable').'|numeric|between:-90,90',
            'longitude' => ($requireGeo ? 'required' : 'nullable').'|numeric|between:-180,180',
            'accuracy' => ($requireGeo ? 'required' : 'nullable').'|numeric|min:0|max:5000',
            'captured_at' => ($requireGeo ? 'required' : 'nullable').'|date',
        ]);

        $employeeId = (int) $request->attributes->get('employee_id');
        $result = $this->attendanceService->checkIn(
            $employeeId,
            isset($validated['latitude']) ? (float) $validated['latitude'] : null,
            isset($validated['longitude']) ? (float) $validated['longitude'] : null,
            isset($validated['accuracy']) ? (float) $validated['accuracy'] : null,
            $validated['captured_at'] ?? null,
            $request->ip()
        );

        $status = $result['success'] ? 200 : ($result['message'] === 'أنت خارج النطاق الجغرافي المسموح به.' ? 403 : 422);

        if ($result['success']) {
            return response()->json(array_merge(
                ['success' => true, 'message' => $result['message']],
                $result['data'] ?? []
            ));
        }

        return response()->json($result, $status);
    }

    public function checkOut(Request $request)
    {
        $requireGeo = (bool) config('attendance.require_geolocation', false);
        $validated = $request->validate([
            'latitude' => ($requireGeo ? 'required' : 'nullable').'|numeric|between:-90,90',
            'longitude' => ($requireGeo ? 'required' : 'nullable').'|numeric|between:-180,180',
            'accuracy' => ($requireGeo ? 'required' : 'nullable').'|numeric|min:0|max:5000',
            'captured_at' => ($requireGeo ? 'required' : 'nullable').'|date',
        ]);

        $employeeId = (int) $request->attributes->get('employee_id');
        $result = $this->attendanceService->checkOut(
            $employeeId,
            isset($validated['latitude']) ? (float) $validated['latitude'] : null,
            isset($validated['longitude']) ? (float) $validated['longitude'] : null,
            isset($validated['accuracy']) ? (float) $validated['accuracy'] : null,
            $validated['captured_at'] ?? null,
            $request->ip()
        );

        $status = $result['success'] ? 200 : ($result['message'] === 'أنت خارج النطاق الجغرافي المسموح به.' ? 403 : 422);

        if ($result['success']) {
            return response()->json(array_merge(
                ['success' => true, 'message' => $result['message']],
                $result['data'] ?? []
            ));
        }

        return response()->json($result, $status);
    }

    public function submitRequest(Request $request)
    {
        $allowedTypes = RequestType::query()
            ->where('is_active', true)
            ->pluck('code')
            ->all();

        if (empty($allowedTypes)) {
            $allowedTypes = ['permission', 'late', 'absence', 'correction'];
        }

        $validated = $request->validate([
            'type' => 'required|string|in:'.implode(',', $allowedTypes),
            'date' => 'required|date|after_or_equal:today',
            'from_time' => 'nullable|date_format:H:i',
            'to_time' => 'nullable|date_format:H:i',
            'reason' => 'required|string|min:10|max:2000',
        ]);

        $selectedType = RequestType::query()->where('code', $validated['type'])->first();
        $requiresTime = $selectedType ? (bool) $selectedType->requires_time : in_array($validated['type'], ['permission', 'late'], true);

        if ($requiresTime) {
            if (empty($validated['from_time']) || empty($validated['to_time'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تحديد وقت من/إلى لهذا النوع من الطلبات.',
                ], 422);
            }
            if ($validated['to_time'] <= $validated['from_time']) {
                return response()->json([
                    'success' => false,
                    'message' => 'وقت النهاية يجب أن يكون بعد وقت البداية.',
                ], 422);
            }
        }

        $employeeId = (int) $request->attributes->get('employee_id');

        $approvalChain = $this->buildApprovalChain($employeeId);
        $firstApproverId = $approvalChain[0] ?? null;

        EmployeeRequest::create([
            'employee_id' => $employeeId,
            'type' => $validated['type'],
            'date' => $validated['date'],
            'from_time' => $validated['from_time'] ?? null,
            'to_time' => $validated['to_time'] ?? null,
            'reason' => $validated['reason'],
            'status' => 'pending',
            'approval_chain' => $approvalChain,
            'approval_step' => 0,
            'current_approver_employee_id' => $firstApproverId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلبك بنجاح وسيتم مراجعته.',
        ]);
    }

    private function buildApprovalChain(int $employeeId): array
    {
        $chain = [];
        $visited = [$employeeId];
        $current = Employee::query()->find($employeeId);
        $guard = 0;

        while ($current && ! empty($current->line_manager) && $guard < 10) {
            $guard++;

            $manager = Employee::query()
                ->where('employee_id', (string) $current->line_manager)
                ->orWhere('id', (int) $current->line_manager)
                ->first();

            if (! $manager || in_array($manager->id, $visited, true)) {
                break;
            }

            $chain[] = $manager->id;
            $visited[] = $manager->id;
            $current = $manager;
        }

        return $chain;
    }

    public function getLocations(Request $request)
    {
        $employeeId = (int) $request->attributes->get('employee_id');

        $locations = \App\Models\EmployeeLocation::whereHas('employees', fn ($q) => $q->where('employees.id', $employeeId))
            ->where('is_active', true)
            ->get(['id', 'name', 'latitude', 'longitude', 'radius_meters']);

        return response()->json($locations);
    }

    public function zoneStatus(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $employeeId = (int) $request->attributes->get('employee_id');
        $status = $this->attendanceService->zoneStatus(
            $employeeId,
            (float) $validated['latitude'],
            (float) $validated['longitude']
        );

        return response()->json([
            'success' => true,
            'inside' => (bool) $status['inside'],
            'has_locations' => (bool) $status['has_locations'],
            'nearest_name' => $status['nearest_name'],
            'nearest_distance_m' => $status['nearest_distance_m'],
        ]);
    }
}

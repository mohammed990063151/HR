<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\EmployeeLocation;
use Carbon\Carbon;

class AttendanceService
{
    public function __construct(
        private GeolocationService $geo
    ) {}

    public function employeeHasActiveLocations(int $employeeId): bool
    {
        return EmployeeLocation::query()
            ->whereHas('employees', fn ($q) => $q->where('employees.id', $employeeId))
            ->where('is_active', true)
            ->exists();
    }

    public function isInsideAllowedZone(int $employeeId, float $lat, float $lng): bool
    {
        return $this->zoneStatus($employeeId, $lat, $lng)['inside'];
    }

    /**
     * @return array{
     *   has_locations: bool,
     *   inside: bool,
     *   nearest_name: ?string,
     *   nearest_distance_m: ?int
     * }
     */
    public function zoneStatus(int $employeeId, float $lat, float $lng): array
    {
        $locations = EmployeeLocation::query()
            ->whereHas('employees', fn ($q) => $q->where('employees.id', $employeeId))
            ->where('is_active', true)
            ->get(['name', 'latitude', 'longitude', 'radius_meters']);

        if ($locations->isEmpty()) {
            return [
                'has_locations' => false,
                'inside' => false,
                'nearest_name' => null,
                'nearest_distance_m' => null,
            ];
        }

        $inside = false;
        $nearestName = null;
        $nearestDistance = null;

        foreach ($locations as $loc) {
            $distance = (int) round($this->geo->distanceMeters(
                $lat,
                $lng,
                (float) $loc->latitude,
                (float) $loc->longitude
            ));

            if ($nearestDistance === null || $distance < $nearestDistance) {
                $nearestDistance = $distance;
                $nearestName = (string) $loc->name;
            }

            if ($distance <= (float) $loc->radius_meters) {
                $inside = true;
            }
        }

        return [
            'has_locations' => true,
            'inside' => $inside,
            'nearest_name' => $nearestName,
            'nearest_distance_m' => $nearestDistance,
        ];
    }

    public function resolveCheckInStatus(Carbon $now): string
    {
        $workStart = Carbon::today()->setTimeFromTimeString(config('attendance.work_start'));
        $deadline = $workStart->copy()->addMinutes((int) config('attendance.grace_minutes'));

        return $now->gt($deadline) ? 'late' : 'present';
    }

    protected function mustCheckGeofence(int $employeeId): bool
    {
        if (! config('attendance.require_geolocation', false)) {
            return false;
        }

        return $this->employeeHasActiveLocations($employeeId);
    }

    private function buildGeoNote(array $zone): string
    {
        if (! $zone['has_locations']) {
            return 'تنبيه نطاق: لا توجد مواقع معتمدة لهذا الموظف.';
        }

        if ($zone['inside']) {
            return 'داخل النطاق';
        }

        $nearestName = $zone['nearest_name'] ?: 'غير معروف';
        $nearestDistance = $zone['nearest_distance_m'] ?? '-';

        return "خارج النطاق - أقرب موقع: {$nearestName} ({$nearestDistance}م)";
    }

    /**
     * @return array{success: bool, message: string, data?: array}
     */
    public function checkIn(int $employeeId, ?float $lat, ?float $lng, ?float $accuracy, ?string $capturedAt, ?string $ip): array
    {
        $zone = null;
        if (config('attendance.require_geolocation', false)) {
            if ($lat === null || $lng === null) {
                return ['success' => false, 'message' => 'يلزم السماح بالوصول إلى الموقع لتسجيل الحضور.'];
            }
            $maxAccuracy = (float) config('attendance.max_location_accuracy_m', 300);
            if ($accuracy === null || $accuracy > $maxAccuracy) {
                return ['success' => false, 'message' => "دقة الموقع ضعيفة (±{$accuracy}م). الحد المسموح ±{$maxAccuracy}م. اضغط «موقعي الآن» في مكان مفتوح ثم أعد المحاولة."];
            }
            if (empty($capturedAt)) {
                return ['success' => false, 'message' => 'يلزم تحديث الموقع الآن قبل التسجيل.'];
            }
            $captured = Carbon::parse($capturedAt);
            if ($captured->lt(now()->subSeconds((int) config('attendance.max_location_age_seconds', 90)))) {
                return ['success' => false, 'message' => 'انتهت صلاحية الموقع. اضغط «موقعي الآن» ثم سجّل مباشرة.'];
            }
            $zone = $this->zoneStatus($employeeId, $lat, $lng);
        }

        $existing = Attendance::query()
            ->where('employee_id', $employeeId)
            ->whereDate('date', today())
            ->first();

        if ($existing?->check_in) {
            return ['success' => false, 'message' => 'لقد سجلت حضورك مسبقاً اليوم.'];
        }

        $now = Carbon::now();
        $status = $this->resolveCheckInStatus($now);

        $geoNote = $zone ? $this->buildGeoNote($zone) : null;

        Attendance::query()->updateOrCreate(
            [
                'employee_id' => $employeeId,
                'date' => today()->toDateString(),
            ],
            [
                'check_in' => $now,
                'check_in_lat' => $lat,
                'check_in_lng' => $lng,
                'check_in_ip' => $ip,
                'status' => $status,
                'notes' => $geoNote,
            ]
        );

        $outside = $zone && ! $zone['inside'];
        $message = $outside
            ? 'تم تسجيل الحضور، لكنك خارج نطاق الشركة وتم حفظ موقعك.'
            : 'تم تسجيل حضورك بنجاح.';

        return [
            'success' => true,
            'message' => $message,
            'data' => [
                'time' => $now->format('h:i A'),
                'status' => $status,
                'outside_zone' => (bool) $outside,
            ],
        ];
    }

    /**
     * @return array{success: bool, message: string, data?: array}
     */
    public function checkOut(int $employeeId, ?float $lat, ?float $lng, ?float $accuracy, ?string $capturedAt, ?string $ip): array
    {
        $zone = null;
        if (config('attendance.require_geolocation', false)) {
            if ($lat === null || $lng === null) {
                return ['success' => false, 'message' => 'يلزم السماح بالوصول إلى الموقع لتسجيل الانصراف.'];
            }
            $maxAccuracy = (float) config('attendance.max_location_accuracy_m', 300);
            if ($accuracy === null || $accuracy > $maxAccuracy) {
                return ['success' => false, 'message' => "دقة الموقع ضعيفة (±{$accuracy}م). الحد المسموح ±{$maxAccuracy}م. اضغط «موقعي الآن» في مكان مفتوح ثم أعد المحاولة."];
            }
            if (empty($capturedAt)) {
                return ['success' => false, 'message' => 'يلزم تحديث الموقع الآن قبل التسجيل.'];
            }
            $captured = Carbon::parse($capturedAt);
            if ($captured->lt(now()->subSeconds((int) config('attendance.max_location_age_seconds', 90)))) {
                return ['success' => false, 'message' => 'انتهت صلاحية الموقع. اضغط «موقعي الآن» ثم سجّل مباشرة.'];
            }
            $zone = $this->zoneStatus($employeeId, $lat, $lng);
        }

        $record = Attendance::query()
            ->where('employee_id', $employeeId)
            ->whereDate('date', today())
            ->first();

        if (! $record || ! $record->check_in) {
            return ['success' => false, 'message' => 'لم تسجل حضورك بعد.'];
        }

        if ($record->check_out) {
            return ['success' => false, 'message' => 'لقد سجلت انصرافك مسبقاً.'];
        }

        $now = Carbon::now();
        $hours = round($record->check_in->diffInMinutes($now) / 60, 2);

        $geoNote = $zone ? $this->buildGeoNote($zone) : null;
        $mergedNote = trim(implode(' | ', array_filter([$record->notes, $geoNote])));

        $record->update([
            'check_out' => $now,
            'check_out_lat' => $lat,
            'check_out_lng' => $lng,
            'check_out_ip' => $ip,
            'working_hours' => $hours,
            'notes' => $mergedNote ?: null,
        ]);

        $outside = $zone && ! $zone['inside'];
        $message = $outside
            ? 'تم تسجيل الانصراف، لكنك خارج نطاق الشركة وتم حفظ موقعك.'
            : 'تم تسجيل انصرافك بنجاح.';

        return [
            'success' => true,
            'message' => $message,
            'data' => [
                'time' => $now->format('h:i A'),
                'hours' => round($hours, 1),
                'outside_zone' => (bool) $outside,
            ],
        ];
    }

    public function monthStats(int $employeeId, Carbon $monthStart, Carbon $monthEnd): object
    {
        $stats = Attendance::query()
            ->where('employee_id', $employeeId)
            ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->selectRaw('
                COUNT(*) as total_days,
                SUM(CASE WHEN status = \'present\' THEN 1 ELSE 0 END) as present_days,
                SUM(CASE WHEN status = \'late\' THEN 1 ELSE 0 END) as late_days,
                SUM(CASE WHEN check_in IS NOT NULL AND check_out IS NULL THEN 1 ELSE 0 END) as incomplete_days
            ')
            ->first();

        $stats->deserved_balance = (int) ($stats->present_days ?? 0) + (int) ($stats->late_days ?? 0);
        $stats->remaining_balance = max(((int) ($stats->total_days ?? 0)) - ((int) $stats->deserved_balance), 0);

        return $stats;
    }
}

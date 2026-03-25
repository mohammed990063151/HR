@extends('layouts.master')
@section('content')

@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    // ══════════════════════════════════════
    // التحية حسب الوقت
    // ══════════════════════════════════════
    $hour = (int) date('G');
    if      ($hour >= 0  && $hour <= 9)  $greet = 'صباح الخير،';
    elseif  ($hour >= 10 && $hour <= 11) $greet = 'نهارك سعيد،';
    elseif  ($hour >= 12 && $hour <= 15) $greet = 'مساء الخير،';
    else                                  $greet = 'مساء النور،';

    $today      = Carbon::today();
    $monthStart = Carbon::now()->startOfMonth();

    // ══════════════════════════════════════
    // اكتشاف اسم العمود الصحيح في جدول departments
    // ══════════════════════════════════════
    $deptColumns   = Schema::getColumnListing('departments');
    $deptNameCol   = collect($deptColumns)->first(fn($c) => in_array(strtolower($c), ['name','dept_name','department_name','title'])) ?? $deptColumns[1] ?? 'name';

    // ══════════════════════════════════════
    // أرقام البطاقات
    // ══════════════════════════════════════
    $totalEmployees   = DB::table('employees')->count();
    $totalDepartments = DB::table('departments')->count();
    $pendingLeaves    = DB::table('leaves')->whereIn('status', ['pending','Pending'])->count();

    $presentToday = DB::table('zk_attendance_logs')
        ->whereDate('timestamp', $today)
        ->distinct('user_id')->count('user_id');

    $absentToday = max(0, $totalEmployees - $presentToday);

    $newEmployeesCount = DB::table('employees')
        ->where('created_at', '>=', Carbon::now()->subDays(30))->count();

    // ══════════════════════════════════════
    // الإجازات هذا الشهر
    // ══════════════════════════════════════
    $leavesMonth = DB::table('leaves')
        ->whereMonth('created_at', $today->month)
        ->whereYear('created_at',  $today->year)
        ->select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')->get()->keyBy(fn($r) => strtolower($r->status));

    $leaveApproved = $leavesMonth->get('approved')?->count ?? 0;
    $leavePending  = $leavesMonth->get('pending')?->count  ?? 0;
    $leaveRejected = $leavesMonth->get('rejected')?->count ?? 0;
    $leaveTotal    = max(1, $leaveApproved + $leavePending + $leaveRejected);

    // ══════════════════════════════════════
    // الرواتب
    // ══════════════════════════════════════
    $salaryThisMonth = DB::table('staff_salaries')
        ->whereMonth('created_at', $today->month)
        ->whereYear('created_at',  $today->year)
        ->sum('salary') ?: 0;

    $salaryLastMonth = DB::table('staff_salaries')
        ->whereMonth('created_at', $today->copy()->subMonth()->month)
        ->whereYear('created_at',  $today->copy()->subMonth()->year)
        ->sum('salary') ?: 0;

    $maxSalary  = max(1, $salaryThisMonth, $salaryLastMonth);

    // ══════════════════════════════════════
    // ساعات العمل هذا الشهر
    // ══════════════════════════════════════
    try {
        $hoursRows = DB::table('zk_attendance_logs')
            ->join('employees','employees.id','=','zk_attendance_logs.user_id')
            ->whereBetween('zk_attendance_logs.timestamp', [$monthStart, Carbon::now()])
            ->select(DB::raw('
                TIMESTAMPDIFF(MINUTE,
                    MIN(zk_attendance_logs.timestamp),
                    MAX(zk_attendance_logs.timestamp)
                ) as mins
            '))
            ->groupBy('employees.id', DB::raw('DATE(zk_attendance_logs.timestamp)'))
            ->get();
        $totalHoursMonth = round($hoursRows->sum('mins') / 60, 1);
    } catch (\Exception $e) {
        $totalHoursMonth = 0;
    }

    // ══════════════════════════════════════
    // الأقسام مع عدد الموظفين (إصلاح اسم العمود)
    // ══════════════════════════════════════
    try {
        $departments = DB::table('departments')
            ->leftJoin('employees','employees.department_id','=','departments.id')
            ->select(
                DB::raw("departments.`{$deptNameCol}` as dept_name"),
                DB::raw('COUNT(employees.id) as emp_count')
            )
            ->groupBy('departments.id', DB::raw("departments.`{$deptNameCol}`"))
            ->orderBy('emp_count','desc')
            ->limit(6)->get();
    } catch (\Exception $e) {
        $departments = collect();
    }

    // ══════════════════════════════════════
    // حضور اليوم
    // ══════════════════════════════════════
    try {
        $recentAttendance = DB::table('zk_attendance_logs')
            ->join('employees','employees.id','=','zk_attendance_logs.user_id')
            ->select([
                'employees.name as employee_name',
                DB::raw('MIN(zk_attendance_logs.timestamp) as check_in'),
                DB::raw('MAX(zk_attendance_logs.timestamp) as check_out'),
            ])
            ->whereDate('zk_attendance_logs.timestamp', $today)
            ->groupBy('employees.id','employees.name')
            ->orderBy('check_in','desc')
            ->limit(8)->get();
    } catch (\Exception $e) {
        $recentAttendance = collect();
    }

    // ══════════════════════════════════════
    // الغائبون اليوم
    // ══════════════════════════════════════
    try {
        $presentIds      = DB::table('zk_attendance_logs')->whereDate('timestamp',$today)->pluck('user_id');
        $absentEmployees = DB::table('employees')->whereNotIn('id',$presentIds)
            ->select('name','employee_id')->limit(5)->get();
    } catch (\Exception $e) {
        $absentEmployees = collect();
    }

    // ══════════════════════════════════════
    // الموظفون الجدد
    // ══════════════════════════════════════
    try {
        $newEmployees = DB::table('employees')
            ->where('created_at','>=', Carbon::now()->subDays(30))
            ->select('name','employee_id','created_at')
            ->orderBy('created_at','desc')->limit(5)->get();
    } catch (\Exception $e) {
        $newEmployees = collect();
    }

    // ══════════════════════════════════════
    // بيانات الرسم البياني - آخر 7 أيام
    // ══════════════════════════════════════
    $chartDays = []; $chartPresent = []; $chartAbsent = [];
    for ($i = 6; $i >= 0; $i--) {
        $day = Carbon::now()->subDays($i);
        try {
            $cnt = DB::table('zk_attendance_logs')
                ->whereDate('timestamp', $day)
                ->distinct('user_id')->count('user_id');
        } catch (\Exception $e) {
            $cnt = 0;
        }
        $chartDays[]    = $day->locale('ar')->isoFormat('dd D/M');
        $chartPresent[] = $cnt;
        $chartAbsent[]  = max(0, $totalEmployees - $cnt);
    }

    // نسبة الحضور اليوم
    $attendanceRate = $totalEmployees > 0 ? round($presentToday / $totalEmployees * 100) : 0;
@endphp

{{-- ══════════════ STYLES ══════════════ --}}
<style>
:root {
    --primary:       #4f46e5;
    --primary-light: #818cf8;
    --primary-pale:  rgba(79,70,229,.10);
    --success:       #10b981;
    --success-pale:  rgba(16,185,129,.12);
    --danger:        #ef4444;
    --danger-pale:   rgba(239,68,68,.12);
    --warning:       #f59e0b;
    --warning-pale:  rgba(245,158,11,.12);
    --info:          #06b6d4;
    --info-pale:     rgba(6,182,212,.12);
    --purple:        #8b5cf6;
    --purple-pale:   rgba(139,92,246,.12);
    --text:          #1e293b;
    --text-muted:    #64748b;
    --border:        rgba(15,23,42,.07);
    --card-bg:       #ffffff;
    --page-bg:       #f8fafc;
    --radius:        14px;
    --shadow:        0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    --shadow-hover:  0 4px 20px rgba(79,70,229,.15);
    --transition:    .22s cubic-bezier(.4,0,.2,1);
}

/* ── Page wrapper ── */
.hr-dash { background: var(--page-bg); min-height: 100vh; padding: 0 0 40px; }

/* ── Header ── */
.hr-header { margin-bottom: 28px; }
.hr-header h3 { font-size: 1.55rem; font-weight: 700; color: var(--text); margin: 0 0 4px; }
.hr-header .sub { font-size: .88rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
.hr-header .sub i { color: var(--primary); }

/* ── Stat cards ── */
.stat-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 20px 20px 18px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1px solid var(--border);
    transition: box-shadow var(--transition), transform var(--transition);
    height: 100%;
}
.stat-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-2px); }
.stat-icon {
    width: 52px; height: 52px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 22px;
}
.stat-body { flex: 1; min-width: 0; }
.stat-body h3 { font-size: 1.65rem; font-weight: 800; color: var(--text); margin: 0 0 2px; line-height: 1; }
.stat-body span { font-size: .8rem; color: var(--text-muted); font-weight: 500; }
.stat-badge { font-size: .72rem; padding: 3px 8px; border-radius: 20px; font-weight: 600; white-space: nowrap; }

/* ── Cards ── */
.hr-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    height: 100%;
}
.hr-card .hr-card-head {
    padding: 16px 20px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
}
.hr-card .hr-card-head h5 {
    font-size: .95rem; font-weight: 700; color: var(--text); margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.hr-card .hr-card-body { padding: 20px; }
.hr-card .hr-card-body.p-0 { padding: 0; }

/* ── Btn outline ── */
.btn-outline-primary {
    font-size: .78rem; padding: 5px 12px; border-radius: 8px;
    border: 1.5px solid var(--primary); color: var(--primary);
    background: transparent; font-weight: 600;
    transition: background var(--transition), color var(--transition);
    text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
}
.btn-outline-primary:hover { background: var(--primary); color: #fff; }

/* ── Table ── */
.hr-table { width: 100%; border-collapse: collapse; }
.hr-table thead th {
    font-size: .76rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .04em; color: var(--text-muted);
    padding: 10px 16px; border-bottom: 1px solid var(--border);
    background: #fafbfc; white-space: nowrap;
}
.hr-table tbody td {
    padding: 11px 16px; border-bottom: 1px solid var(--border);
    font-size: .875rem; color: var(--text); vertical-align: middle;
}
.hr-table tbody tr:last-child td { border-bottom: none; }
.hr-table tbody tr:hover td { background: rgba(79,70,229,.03); }

/* ── Avatar ── */
.emp-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
}

/* ── Badge ── */
.badge-soft {
    font-size: .72rem; padding: 3px 9px; border-radius: 20px;
    font-weight: 600; display: inline-block;
}
.badge-soft.success { background: var(--success-pale); color: #059669; }
.badge-soft.danger  { background: var(--danger-pale);  color: #dc2626; }
.badge-soft.warning { background: var(--warning-pale); color: #d97706; }
.badge-soft.info    { background: var(--info-pale);    color: #0891b2; }
.badge-soft.primary { background: var(--primary-pale); color: var(--primary); }

/* ── Progress ── */
.hr-progress { height: 6px; border-radius: 10px; background: rgba(0,0,0,.06); overflow: hidden; margin-top: 6px; }
.hr-progress .bar { height: 100%; border-radius: 10px; transition: width .6s ease; }

/* ── Leave stats ── */
.leave-stat { margin-bottom: 16px; }
.leave-stat:last-child { margin-bottom: 0; }
.leave-stat .ls-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
.leave-stat .ls-row span { font-size: .84rem; color: var(--text-muted); font-weight: 500; }
.leave-stat .ls-row strong { font-size: .84rem; color: var(--text); font-weight: 700; }

/* ── Employee list item ── */
.emp-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 0; border-bottom: 1px solid var(--border);
}
.emp-item:last-child { border-bottom: none; }
.emp-info { flex: 1; min-width: 0; }
.emp-info .name { font-size: .875rem; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.emp-info .sub  { font-size: .76rem; color: var(--text-muted); margin-top: 1px; }

/* ── Rate ring ── */
.rate-ring-wrap { text-align: center; margin-bottom: 12px; }
.rate-ring-wrap .rate-num { font-size: 2rem; font-weight: 800; color: var(--primary); line-height: 1; }
.rate-ring-wrap .rate-lbl { font-size: .78rem; color: var(--text-muted); margin-top: 2px; }

/* ── Section divider ── */
.sec-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }

/* ── Chart card ── */
.chart-wrap { position: relative; }

/* ── Dept bar ── */
.dept-row { display: flex; align-items: center; gap: 10px; margin-bottom: 13px; }
.dept-row:last-child { margin-bottom: 0; }
.dept-name { font-size: .83rem; font-weight: 600; color: var(--text); min-width: 90px; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; flex-shrink: 0; text-align: right; }
.dept-bar-wrap { flex: 1; }
.dept-bar-track { height: 7px; border-radius: 10px; background: rgba(0,0,0,.06); overflow: hidden; }
.dept-bar-fill  { height: 100%; border-radius: 10px; transition: width .7s ease; }
.dept-count { font-size: .78rem; font-weight: 700; color: var(--text-muted); min-width: 28px; text-align: left; flex-shrink: 0; }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 30px 20px; color: var(--text-muted); }
.empty-state i { font-size: 2rem; margin-bottom: 8px; display: block; opacity: .4; }
.empty-state p { font-size: .84rem; margin: 0; }

/* ── Animate in ── */
@keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
.anim { animation: fadeUp .4s ease both; }
.anim-1 { animation-delay: .05s; }
.anim-2 { animation-delay: .10s; }
.anim-3 { animation-delay: .15s; }
.anim-4 { animation-delay: .20s; }
.anim-5 { animation-delay: .25s; }
.anim-6 { animation-delay: .30s; }

/* responsive */
@media (max-width: 575px) {
    .stat-body h3 { font-size: 1.35rem; }
    .stat-icon { width: 44px; height: 44px; font-size: 18px; }
}
</style>
<br /><br /><br  />
<div class="page-wrapper hr-dash">
<div class="content container-fluid">

    {{-- ══ Header ══ --}}
    <div class="page-header hr-header anim">
        <h3>{{ $greet }} {{ Session::get('name') }}</h3>
        <div class="sub">
            <i class="fa fa-calendar-o"></i>
            {{ Carbon::now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
            &nbsp;·&nbsp;
            <i class="fa fa-clock-o"></i>
            {{ Carbon::now()->format('h:i A') }}
        </div>
    </div>

    {{-- ══ Row 1: بطاقات الحضور ══ --}}
    <div class="row g-3 mb-3">
        @php
        $r1 = [
            ['icon'=>'fa-users',        'color'=>'var(--primary)', 'bg'=>'var(--primary-pale)', 'val'=>$totalEmployees,   'label'=>'إجمالي الموظفين', 'badge'=>null],
            ['icon'=>'fa-check-circle', 'color'=>'var(--success)', 'bg'=>'var(--success-pale)', 'val'=>$presentToday,     'label'=>'حاضرون اليوم',    'badge'=>['class'=>'success','text'=>$attendanceRate.'%']],
            ['icon'=>'fa-times-circle', 'color'=>'var(--danger)',  'bg'=>'var(--danger-pale)',  'val'=>$absentToday,      'label'=>'غائبون اليوم',    'badge'=>$absentToday > 0 ? ['class'=>'danger','text'=>'يحتاج متابعة'] : null],
            ['icon'=>'fa-clock-o',      'color'=>'var(--warning)', 'bg'=>'var(--warning-pale)', 'val'=>$pendingLeaves,    'label'=>'إجازات معلقة',    'badge'=>$pendingLeaves > 0 ? ['class'=>'warning','text'=>'بانتظار القرار'] : null],
        ];
        @endphp
        @foreach($r1 as $i => $c)
        <div class="col-6 col-md-3 anim anim-{{ $i+1 }}">
            <div class="stat-card">
                <div class="stat-icon" style="background:{{ $c['bg'] }}; color:{{ $c['color'] }};">
                    <i class="fa {{ $c['icon'] }}"></i>
                </div>
                <div class="stat-body">
                    <h3>{{ number_format($c['val']) }}</h3>
                    <span>{{ $c['label'] }}</span>
                    @if($c['badge'])
                    <div class="mt-1">
                        <span class="badge-soft {{ $c['badge']['class'] }}">{{ $c['badge']['text'] }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══ Row 2: بطاقات ثانوية ══ --}}
    <div class="row g-3 mb-3">
        @php
        $r2 = [
            ['icon'=>'la la-building',     'color'=>'var(--purple)', 'bg'=>'var(--purple-pale)', 'val'=>$totalDepartments,     'label'=>'الأقسام'],
            ['icon'=>'fa fa-user-plus',    'color'=>'var(--info)',   'bg'=>'var(--info-pale)',   'val'=>$newEmployeesCount,    'label'=>'موظفون جدد (٣٠ يوم)'],
            ['icon'=>'fa fa-check',        'color'=>'var(--success)','bg'=>'var(--success-pale)','val'=>$leaveApproved,        'label'=>'إجازات موافق عليها'],
            ['icon'=>'fa fa-hourglass-half','color'=>'var(--primary)','bg'=>'var(--primary-pale)','val'=>$totalHoursMonth.' س', 'label'=>'ساعات العمل هذا الشهر'],
        ];
        @endphp
        @foreach($r2 as $i => $c)
        <div class="col-6 col-md-3 anim anim-{{ $i+1 }}">
            <div class="stat-card">
                <div class="stat-icon" style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; font-size:20px;">
                    <i class="{{ $c['icon'] }}"></i>
                </div>
                <div class="stat-body">
                    <h3>{{ $c['val'] }}</h3>
                    <span>{{ $c['label'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══ Chart + Stats ══ --}}
    <div class="row g-3 mb-3">

        <div class="col-md-8 anim anim-1">
            <div class="hr-card">
                <div class="hr-card-head">
                    <h5><i class="fa fa-bar-chart" style="color:var(--primary);font-size:.9rem;"></i> الحضور — آخر ٧ أيام</h5>
                    <a href="{{ route('attendance/page') }}" class="btn-outline-primary">
                        <i class="fa fa-external-link" style="font-size:.7rem;"></i> التفاصيل
                    </a>
                </div>
                <div class="hr-card-body chart-wrap">
                    <canvas id="attendanceChart" height="115"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 anim anim-2">
            <div class="hr-card">
                <div class="hr-card-head">
                    <h5><i class="fa fa-umbrella" style="color:var(--warning);font-size:.9rem;"></i> إجازات الشهر</h5>
                </div>
                <div class="hr-card-body">
                    {{-- نسبة الحضور ──────── --}}
                    <div class="rate-ring-wrap">
                        <div class="rate-num">{{ $attendanceRate }}%</div>
                        <div class="rate-lbl">نسبة الحضور اليوم</div>
                        <div class="hr-progress mt-2">
                            <div class="bar" style="width:{{ $attendanceRate }}%; background: linear-gradient(90deg, var(--primary), var(--primary-light));"></div>
                        </div>
                    </div>

                    <hr class="sec-divider">

                    <div class="leave-stat">
                        <div class="ls-row"><span>✅ موافق عليها</span><strong>{{ $leaveApproved }}</strong></div>
                        <div class="hr-progress"><div class="bar" style="width:{{ round($leaveApproved/$leaveTotal*100) }}%; background:var(--success);"></div></div>
                    </div>
                    <div class="leave-stat">
                        <div class="ls-row"><span>⏳ قيد الانتظار</span><strong>{{ $leavePending }}</strong></div>
                        <div class="hr-progress"><div class="bar" style="width:{{ round($leavePending/$leaveTotal*100) }}%; background:var(--warning);"></div></div>
                    </div>
                    <div class="leave-stat">
                        <div class="ls-row"><span>❌ مرفوضة</span><strong>{{ $leaveRejected }}</strong></div>
                        <div class="hr-progress"><div class="bar" style="width:{{ round($leaveRejected/$leaveTotal*100) }}%; background:var(--danger);"></div></div>
                    </div>

                    <hr class="sec-divider">

                    <h6 style="font-size:.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:12px;">الرواتب</h6>
                    <div class="leave-stat">
                        <div class="ls-row"><span>هذا الشهر</span><strong>{{ number_format($salaryThisMonth) }} ر.س</strong></div>
                        <div class="hr-progress"><div class="bar" style="width:{{ round($salaryThisMonth/$maxSalary*100) }}%; background:var(--primary);"></div></div>
                    </div>
                    <div class="leave-stat">
                        <div class="ls-row"><span>الشهر الماضي</span><strong>{{ number_format($salaryLastMonth) }} ر.س</strong></div>
                        <div class="hr-progress"><div class="bar" style="width:{{ round($salaryLastMonth/$maxSalary*100) }}%; background:var(--info);"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ Departments + Attendance ══ --}}
    <div class="row g-3 mb-3">

        <div class="col-md-5 anim anim-1">
            <div class="hr-card">
                <div class="hr-card-head">
                    <h5><i class="la la-building" style="color:var(--purple);"></i> الأقسام</h5>
                    <a href="{{ route('form/departments/page') }}" class="btn-outline-primary">الكل</a>
                </div>
                <div class="hr-card-body">
                    @php
                    $dColors = ['var(--primary)','var(--success)','var(--warning)','var(--danger)','var(--info)','var(--purple)'];
                    $maxEmp  = $departments->max('emp_count') ?: 1;
                    @endphp
                    @forelse($departments as $dept)
                    @php $pct = round($dept->emp_count / $maxEmp * 100); @endphp
                    <div class="dept-row">
                        <div class="dept-name">{{ $dept->dept_name ?? '-' }}</div>
                        <div class="dept-bar-wrap">
                            <div class="dept-bar-track">
                                <div class="dept-bar-fill" style="width:{{ $pct }}%; background:{{ $dColors[$loop->index % 6] }};"></div>
                            </div>
                        </div>
                        <div class="dept-count">{{ $dept->emp_count }}</div>
                    </div>
                    @empty
                    <div class="empty-state"><i class="fa fa-inbox"></i><p>لا توجد أقسام</p></div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-7 anim anim-2">
            <div class="hr-card">
                <div class="hr-card-head">
                    <h5>
                        <i class="fa fa-user-check" style="color:var(--success);"></i>
                        حضور اليوم
                        <span class="badge-soft success">{{ $presentToday }}</span>
                    </h5>
                    <a href="{{ route('attendance/employee/page') }}" class="btn-outline-primary">الكل</a>
                </div>
                <div class="hr-card-body p-0">
                    <div class="table-responsive">
                        <table class="hr-table">
                            <thead>
                                <tr>
                                    <th>الموظف</th>
                                    <th>دخول</th>
                                    <th>خروج</th>
                                    <th class="text-center">المدة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAttendance as $att)
                                @php
                                    $in  = $att->check_in  ? Carbon::parse($att->check_in)  : null;
                                    $out = $att->check_out ? Carbon::parse($att->check_out) : null;
                                    $hrs = ($in && $out && $out->ne($in)) ? round($in->diffInMinutes($out)/60,1) : null;
                                    $avatarColors = [
                                        'linear-gradient(135deg,#6366f1,#a78bfa)',
                                        'linear-gradient(135deg,#10b981,#34d399)',
                                        'linear-gradient(135deg,#f59e0b,#fbbf24)',
                                        'linear-gradient(135deg,#ef4444,#f87171)',
                                        'linear-gradient(135deg,#06b6d4,#67e8f9)',
                                        'linear-gradient(135deg,#8b5cf6,#c4b5fd)',
                                    ];
                                    $ac = $avatarColors[$loop->index % 6];
                                @endphp
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:9px;">
                                            <div class="emp-avatar" style="background:{{ $ac }};">
                                                {{ mb_substr($att->employee_name ?? '?', 0, 1) }}
                                            </div>
                                            <span style="font-weight:600;">{{ $att->employee_name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($in)
                                            <span class="badge-soft success">{{ $in->format('h:i A') }}</span>
                                        @else <span style="color:var(--text-muted);">—</span> @endif
                                    </td>
                                    <td>
                                        @if($out && $out->ne($in))
                                            <span class="badge-soft danger">{{ $out->format('h:i A') }}</span>
                                        @else
                                            <span class="badge-soft warning">داخل</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($hrs)
                                            <span class="badge-soft primary">{{ $hrs }} س</span>
                                        @else <span style="color:var(--text-muted);">—</span> @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fa fa-calendar-times-o"></i>
                                            <p>لا يوجد حضور مسجل اليوم</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ Absent + New Employees ══ --}}
    <div class="row g-3">

        <div class="col-md-6 anim anim-1">
            <div class="hr-card">
                <div class="hr-card-head">
                    <h5>
                        <i class="fa fa-user-times" style="color:var(--danger);"></i>
                        غائبون اليوم
                        @if($absentToday > 0)
                            <span class="badge-soft danger">{{ $absentToday }}</span>
                        @endif
                    </h5>
                </div>
                <div class="hr-card-body">
                    @forelse($absentEmployees as $emp)
                    <div class="emp-item">
                        <div class="emp-avatar" style="background:linear-gradient(135deg,#ef4444,#f97316);">
                            {{ mb_substr($emp->name ?? '?', 0, 1) }}
                        </div>
                        <div class="emp-info">
                            <div class="name">{{ $emp->name }}</div>
                            <div class="sub">{{ $emp->employee_id ?? 'بدون رقم' }}</div>
                        </div>
                        <span class="badge-soft danger">غائب</span>
                    </div>
                    @empty
                    <div class="empty-state" style="color:var(--success);">
                        <i class="fa fa-check-circle" style="opacity:1; color:var(--success);"></i>
                        <p>جميع الموظفين حاضرون اليوم 🎉</p>
                    </div>
                    @endforelse

                    @if($absentToday > 5)
                    <p class="text-center mt-3 mb-0" style="font-size:.8rem; color:var(--text-muted);">
                        + {{ $absentToday - 5 }} موظف غائب آخر
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 anim anim-2">
            <div class="hr-card">
                <div class="hr-card-head">
                    <h5>
                        <i class="fa fa-user-plus" style="color:var(--info);"></i>
                        موظفون جدد
                        @if($newEmployeesCount > 0)
                            <span class="badge-soft info">{{ $newEmployeesCount }}</span>
                        @endif
                    </h5>
                    <a href="{{ route('all/employee/card') }}" class="btn-outline-primary">الكل</a>
                </div>
                <div class="hr-card-body">
                    @forelse($newEmployees as $emp)
                    <div class="emp-item">
                        <div class="emp-avatar" style="background:linear-gradient(135deg,#6366f1,#a78bfa);">
                            {{ mb_substr($emp->name ?? '?', 0, 1) }}
                        </div>
                        <div class="emp-info">
                            <div class="name">{{ $emp->name }}</div>
                            <div class="sub">انضم {{ Carbon::parse($emp->created_at)->locale('ar')->diffForHumans() }}</div>
                        </div>
                        <span class="badge-soft success">جديد</span>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <p>لا يوجد موظفون جدد في آخر ٣٠ يوم</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('attendanceChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartDays),
            datasets: [
                {
                    label: 'حاضرون',
                    data: @json($chartPresent),
                    backgroundColor: 'rgba(79,70,229,0.80)',
                    borderColor: 'rgba(79,70,229,1)',
                    borderWidth: 0,
                    borderRadius: 7,
                    borderSkipped: false,
                },
                {
                    label: 'غائبون',
                    data: @json($chartAbsent),
                    backgroundColor: 'rgba(239,68,68,0.28)',
                    borderColor: 'rgba(239,68,68,.7)',
                    borderWidth: 0,
                    borderRadius: 7,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 16, font: { size: 12 } }
                },
                tooltip: {
                    callbacks: {
                        label: c => c.dataset.label + ': ' + c.parsed.y + ' موظف'
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: {
                    beginAtZero: true,
                    max: {{ max(1, $totalEmployees) }},
                    ticks: { stepSize: Math.max(1, Math.ceil({{ $totalEmployees }} / 5)), font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,.05)' }
                }
            }
        }
    });
});
</script>
@endsection
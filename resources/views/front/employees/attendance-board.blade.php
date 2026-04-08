<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الحضور - {{ $employeeName }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body{margin:0;background:#f7f8fb;color:#1f2937;font-family:'Cairo',sans-serif}
.wrap{max-width:980px;margin:0 auto;padding:14px}
.head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.title{font-weight:700;font-size:1.2rem}
.card{background:#fff;border:1px solid #e7ebf1;border-radius:14px;padding:14px;margin-bottom:12px}
.month-nav{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
.month-nav a{text-decoration:none;color:#374151;font-weight:700;padding:6px 10px;border:1px solid #e7ebf1;border-radius:10px;background:#fff}
.grid{display:grid;grid-template-columns:repeat(7,1fr);gap:6px}
.day{padding:8px 4px;border:1px solid #eceff5;border-radius:8px;text-align:center;text-decoration:none;color:#111827;background:#fafbff}
.day.has{border-color:#c7d2fe;background:#eef2ff}
.day.sel{border-color:#111827;box-shadow:inset 0 0 0 1px #111827}
.muted{color:#6b7280}
.kpi{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.box{border:1px solid #eceff5;border-radius:10px;padding:10px;background:#fff}
.box .l{font-size:.78rem;color:#6b7280}
.box .v{font-weight:700;font-size:1.2rem}
.list .row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px dashed #eceff5}
.list .row:last-child{border-bottom:0}
@media (max-width:640px){.wrap{padding:8px}.day{font-size:.8rem;padding:7px 2px}}
</style>
</head>
<body>
<div class="wrap">
    <div class="head">
        <div class="title">الحضور</div>
        <a href="{{ route('portal.index') }}" class="muted">الرجوع للبوابة</a>
    </div>

    @php
        $prev = $monthStart->copy()->subMonth();
        $next = $monthStart->copy()->addMonth();
    @endphp
    <div class="card">
        <div class="month-nav">
            <a href="{{ route('portal.attendance-board', ['month'=>$prev->month, 'year'=>$prev->year]) }}">السابق</a>
            <div>
                <div style="font-weight:700;text-align:center">{{ $monthStart->locale('ar')->isoFormat('MMMM') }}</div>
                <div class="muted" style="text-align:center">{{ $year }}</div>
            </div>
            <a href="{{ route('portal.attendance-board', ['month'=>$next->month, 'year'=>$next->year]) }}">التالي</a>
        </div>

        <div class="grid" style="margin-bottom:6px">
            <div class="muted" style="text-align:center">ح</div><div class="muted" style="text-align:center">ن</div><div class="muted" style="text-align:center">ث</div><div class="muted" style="text-align:center">ر</div><div class="muted" style="text-align:center">خ</div><div class="muted" style="text-align:center">ج</div><div class="muted" style="text-align:center">س</div>
        </div>
        <div class="grid">
            @for($d=1; $d <= $monthEnd->day; $d++)
                @php
                    $dateKey = \Carbon\Carbon::create($year,$month,$d)->toDateString();
                    $has = $recordsByDate->has($dateKey);
                    $sel = $selectedDate === $dateKey;
                @endphp
                <a class="day {{ $has ? 'has' : '' }} {{ $sel ? 'sel' : '' }}" href="{{ route('portal.attendance-board', ['month'=>$month,'year'=>$year,'day'=>$d]) }}">{{ $d }}</a>
            @endfor
        </div>
    </div>

    <div class="card">
        <div style="font-weight:700;margin-bottom:10px">بيانات يوم {{ \Carbon\Carbon::parse($selectedDate)->format('Y-m-d') }}</div>
        @php
            $in = $selectedRecord?->check_in;
            $out = $selectedRecord?->check_out;
            $hours = ($in && $out) ? round($in->diffInMinutes($out)/60, 2) : null;
        @endphp
        <div class="kpi">
            <div class="box"><div class="l">أول حضور</div><div class="v">{{ $in ? $in->format('h:i A') : 'لا يوجد' }}</div></div>
            <div class="box"><div class="l">آخر انصراف</div><div class="v">{{ $out ? $out->format('h:i A') : 'لا يوجد' }}</div></div>
            <div class="box"><div class="l">مدة العمل</div><div class="v">{{ $hours !== null ? $hours.' ساعة' : '--' }}</div></div>
            <div class="box"><div class="l">الحالة</div><div class="v">{{ $selectedRecord?->status ?? '--' }}</div></div>
        </div>
    </div>

    <div class="card list">
        <div style="font-weight:700;margin-bottom:8px">كل سجلات الشهر</div>
        @forelse($records as $rec)
            <div class="row">
                <div>{{ $rec->date->format('Y-m-d') }}</div>
                <div class="muted">{{ $rec->check_in?->format('h:i A') ?? '--' }} → {{ $rec->check_out?->format('h:i A') ?? '--' }}</div>
            </div>
        @empty
            <div class="muted">لا يوجد سجل في هذا الشهر.</div>
        @endforelse
    </div>
</div>
</body>
</html>

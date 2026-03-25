@extends('layouts.master')
@section('content')

@php
    $todayH  = isset($workMinutesToday) ? round($workMinutesToday/60, 2) : 0;
    $weekH   = isset($workMinutesWeek)  ? round($workMinutesWeek/60,  2) : 0;
    $monthH  = isset($workMinutesMonth) ? round($workMinutesMonth/60, 2) : 0;

    $dayTarget   = 8;
    $weekTarget  = 40;
    $monthTarget = 160;

    $dayPercent   = $dayTarget   ? min(100, round(($todayH/$dayTarget)*100))   : 0;
    $weekPercent  = $weekTarget  ? min(100, round(($weekH/$weekTarget)*100))   : 0;
    $monthPercent = $monthTarget ? min(100, round(($monthH/$monthTarget)*100)) : 0;
@endphp

{{-- ══════════ STYLES ══════════ --}}
<style>
:root {
    --p:       #2563eb;
    --p-l:     #60a5fa;
    --p-pale:  rgba(37,99,235,.09);
    --g:       #059669;
    --g-pale:  rgba(5,150,105,.10);
    --r:       #dc2626;
    --r-pale:  rgba(220,38,38,.10);
    --o:       #d97706;
    --o-pale:  rgba(217,119,6,.10);
    --c:       #0891b2;
    --c-pale:  rgba(8,145,178,.10);
    --v:       #7c3aed;
    --v-pale:  rgba(124,58,237,.10);
    --txt:     #0f172a;
    --muted:   #64748b;
    --border:  rgba(15,23,42,.08);
    --bg:      #f1f5f9;
    --card:    #ffffff;
    --radius:  12px;
    --sh:      0 1px 3px rgba(0,0,0,.05),0 4px 14px rgba(0,0,0,.04);
    --sh2:     0 6px 24px rgba(37,99,235,.14);
}

.att-page { background: var(--bg); min-height: 100vh; }
.att-page .page-header h3 { font-size: 1.4rem; font-weight: 800; color: var(--txt); }

.ac { background:var(--card); border-radius:var(--radius); box-shadow:var(--sh); border:1px solid var(--border); overflow:hidden; }
.ac-head { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
.ac-head h5 { font-size:.9rem; font-weight:700; color:var(--txt); margin:0; display:flex; align-items:center; gap:7px; }
.ac-body { padding:18px; }

.sync-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
    border-radius: var(--radius);
    padding: 20px 22px;
    color: #fff;
    margin-bottom: 20px;
    box-shadow: var(--sh2);
    position: relative;
    overflow: hidden;
}
.sync-card::before {
    content:''; position:absolute; top:-40px; right:-40px;
    width:160px; height:160px; border-radius:50%;
    background: rgba(255,255,255,.06);
}
.sync-card::after {
    content:''; position:absolute; bottom:-30px; left:60px;
    width:100px; height:100px; border-radius:50%;
    background: rgba(255,255,255,.05);
}
.sync-top { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:14px; }
.sync-title { font-size:1rem; font-weight:700; margin:0 0 4px; }
.sync-meta { font-size:.78rem; opacity:.8; display:flex; gap:16px; flex-wrap:wrap; }
.sync-meta span { display:flex; align-items:center; gap:5px; }
.sync-controls { display:flex; align-items:center; gap:8px; flex-shrink:0; }
.sync-ip {
    background: rgba(255,255,255,.18);
    border: 1.5px solid rgba(255,255,255,.30);
    border-radius: 8px; color: #fff; font-size: .82rem;
    padding: 7px 12px; width: 155px; outline: none;
    backdrop-filter: blur(4px);
}
.sync-ip::placeholder { color:rgba(255,255,255,.55); }
.sync-ip:focus { border-color:rgba(255,255,255,.7); }
.btn-sync {
    background: rgba(255,255,255,.22);
    border: 1.5px solid rgba(255,255,255,.40);
    border-radius: 8px; color: #fff; font-size: .82rem; font-weight: 700;
    padding: 7px 16px; cursor: pointer;
    display: flex; align-items:center; gap:6px;
    transition: background .2s; backdrop-filter: blur(4px); white-space: nowrap;
}
.btn-sync:hover:not(:disabled) { background: rgba(255,255,255,.32); }
.btn-sync:disabled { opacity:.6; cursor:not-allowed; }
.sync-progress-bar {
    height: 3px; background: rgba(255,255,255,.15);
    border-radius: 10px; margin-top: 14px; overflow: hidden; display: none;
}
.sync-progress-bar .fill {
    height: 100%; width: 0%; background: rgba(255,255,255,.7);
    border-radius: 10px; transition: width .4s ease;
    animation: syncPulse 1.5s ease infinite;
}
@keyframes syncPulse { 0%,100%{opacity:.7} 50%{opacity:1} }
.sync-result-box { margin-top:12px; display:none; }
.sync-result-box .sr-inner {
    background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.25);
    border-radius: 9px; padding: 10px 14px; font-size:.82rem;
}
.sync-result-box .sr-inner.err { background:rgba(220,38,38,.25); border-color:rgba(220,38,38,.4); }
.sr-stats { display:flex; gap:16px; flex-wrap:wrap; margin-top:7px; }
.sr-stat { text-align:center; }
.sr-stat .sv { font-size:1.1rem; font-weight:800; }
.sr-stat .sl { font-size:.7rem; opacity:.75; }

.sum-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
@media(max-width:767px){ .sum-grid{grid-template-columns:repeat(2,1fr);} }
.sum-card {
    background:var(--card); border-radius:var(--radius); border:1px solid var(--border);
    box-shadow:var(--sh); padding:16px 18px; display:flex; align-items:center; gap:14px;
    transition: transform .2s, box-shadow .2s;
}
.sum-card:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.08); }
.sum-icon { width:46px; height:46px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.sum-body h4 { font-size:1.4rem; font-weight:800; margin:0 0 2px; color:var(--txt); line-height:1; }
.sum-body small { font-size:.75rem; color:var(--muted); font-weight:500; }

.stat-row { margin-bottom:14px; }
.stat-row:last-child { margin-bottom:0; }
.stat-row .sr-lbl { display:flex; justify-content:space-between; margin-bottom:5px; font-size:.82rem; }
.stat-row .sr-lbl span { color:var(--muted); font-weight:500; }
.stat-row .sr-lbl strong { color:var(--txt); font-weight:700; }
.stat-row .bar-track { height:7px; border-radius:10px; background:rgba(0,0,0,.07); overflow:hidden; }
.stat-row .bar-fill { height:100%; border-radius:10px; transition: width .7s cubic-bezier(.4,0,.2,1); }

.tl-wrap { display:flex; flex-direction:column; gap:0; }
.tl-item { display:flex; gap:14px; padding:10px 0; position:relative; }
.tl-item + .tl-item::before {
    content:''; position:absolute; top:0; right:17px;
    width:2px; height:10px; background:var(--border);
}
.tl-dot { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }
.tl-info .name { font-size:.84rem; font-weight:600; color:var(--txt); }
.tl-info .time { font-size:.76rem; color:var(--muted); margin-top:2px; }

.filter-bar {
    background:var(--card); border-radius:var(--radius); border:1px solid var(--border);
    box-shadow:var(--sh); padding:16px 18px; margin-bottom:16px;
    display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap;
}
.filter-bar .fg { display:flex; flex-direction:column; gap:4px; }
.filter-bar .fg label { font-size:.73rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.04em; }
.filter-bar .fg input,
.filter-bar .fg select {
    border: 1.5px solid var(--border); border-radius: 8px;
    padding: 7px 11px; font-size: .83rem; color: var(--txt);
    background: #f8fafc; outline: none; min-width: 120px; transition: border-color .2s;
}
.filter-bar .fg input:focus,
.filter-bar .fg select:focus { border-color: var(--p); background:#fff; }
.btn-search {
    background: var(--p); color: #fff; border: none;
    border-radius: 8px; padding: 8px 20px; font-size:.83rem; font-weight:700;
    cursor:pointer; display:flex; align-items:center; gap:6px;
    transition: background .2s, transform .15s; white-space: nowrap;
}
.btn-search:hover { background:#1d4ed8; transform:translateY(-1px); }

.att-table-wrap {
    background:var(--card); border-radius:var(--radius); border:1px solid var(--border);
    box-shadow:var(--sh); overflow:hidden;
}
.att-table-head {
    padding: 14px 18px; border-bottom: 1px solid var(--border);
    display: flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;
}
.att-table-head h5 { font-size:.9rem; font-weight:700; color:var(--txt); margin:0; display:flex; align-items:center; gap:7px; }
.att-table { width:100%; border-collapse:collapse; }
.att-table thead th {
    font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em;
    color:var(--muted); padding:11px 16px;
    background:#f8fafc; border-bottom:2px solid var(--border); white-space:nowrap;
}
.att-table tbody td {
    padding:12px 16px; border-bottom:1px solid var(--border);
    font-size:.855rem; color:var(--txt); vertical-align:middle;
}
.att-table tbody tr:last-child td { border-bottom:none; }
.att-table tbody tr:hover td { background:rgba(37,99,235,.025); }

.att-status { display:inline-flex; align-items:center; gap:5px; font-size:.78rem; font-weight:600; padding:4px 10px; border-radius:20px; }
.att-status.present   { background:var(--g-pale); color:var(--g); }
.att-status.late      { background:var(--o-pale); color:var(--o); }
.att-status.absent    { background:var(--r-pale); color:var(--r); }
.att-status.incomplete{ background:var(--v-pale); color:var(--v); }

.t-badge { font-size:.78rem; font-weight:600; padding:3px 9px; border-radius:6px; display:inline-block; }
.t-badge.in   { background:var(--g-pale); color:var(--g); }
.t-badge.out  { background:var(--r-pale); color:var(--r); }
.t-badge.dash { color:var(--muted); }

.h-pill { font-size:.78rem; font-weight:700; padding:3px 10px; border-radius:20px; display:inline-block; }
.h-pill.full    { background:var(--g-pale); color:var(--g); }
.h-pill.partial { background:var(--o-pale); color:var(--o); }
.h-pill.zero    { background:var(--r-pale); color:var(--r); }

.emp-cell { display:flex; align-items:center; gap:9px; }
.emp-av { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#fff; flex-shrink:0; }
.emp-name { font-weight:600; font-size:.855rem; }
.row-num { font-size:.78rem; font-weight:700; color:var(--muted); }

.empty-att { text-align:center; padding:40px 20px; color:var(--muted); }
.empty-att i { font-size:2.2rem; opacity:.3; display:block; margin-bottom:8px; }
.empty-att p { font-size:.84rem; margin:0; }

.att-pagination { padding:12px 18px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; }
</style>

<div class="page-wrapper att-page">
<div class="content container-fluid">

    {{-- Header --}}
    <div class="page-header anim ad-1">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">سجلات الحضور والانصراف</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active">الحضور</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ══ SYNC CARD ══ --}}
    <div class="sync-card anim ad-1">
        <div class="sync-top">
            <div>
                <p class="sync-title">
                    <i class="fa fa-wifi" style="margin-left:6px;"></i>
                    مزامنة جهاز البصمة ZK
                </p>
                <div class="sync-meta">
                    <span><i class="fa fa-clock-o"></i> آخر سجل: <strong id="zk-last-log"><i class="fa fa-spinner fa-spin"></i></strong></span>
                    <span><i class="fa fa-database"></i> إجمالي السجلات: <strong id="zk-total">-</strong></span>
                    <span id="zk-running-badge" style="display:none;background:rgba(255,255,255,.18);padding:2px 8px;border-radius:20px;font-size:.72rem;">⏳ مزامنة جارية…</span>
                </div>
            </div>
            <div class="sync-controls">
                <input type="text" id="zk-ip" class="sync-ip" placeholder="IP الجهاز" value="192.168.10.201">
                <button id="zk-sync-btn" type="button" class="btn-sync" onclick="zkSync()">
                    <i class="fa fa-refresh" id="zk-icon"></i>
                    مزامنة الآن
                </button>
            </div>
        </div>
        <div class="sync-progress-bar" id="sync-pbar"><div class="fill" id="sync-fill"></div></div>
        <div class="sync-result-box" id="sync-result-box">
            <div class="sr-inner" id="sr-inner"></div>
        </div>
    </div>

    {{-- ══ SUMMARY CARDS ══ --}}
    <div class="sum-grid anim ad-2">
        <div class="sum-card">
            <div class="sum-icon" style="background:var(--p-pale);color:var(--p);"><i class="fa fa-sun-o"></i></div>
            <div class="sum-body">
                <h4>{{ $todayH }} <span style="font-size:.85rem;font-weight:500;color:var(--muted);">/ {{$dayTarget}}س</span></h4>
                <small>ساعات اليوم</small>
                <div class="bar-track mt-1" style="height:4px;border-radius:10px;background:rgba(0,0,0,.07);overflow:hidden;">
                    <div style="height:100%;border-radius:10px;width:{{$dayPercent}}%;background:var(--p);transition:width .7s;"></div>
                </div>
            </div>
        </div>
        <div class="sum-card">
            <div class="sum-icon" style="background:var(--o-pale);color:var(--o);"><i class="fa fa-calendar-check-o"></i></div>
            <div class="sum-body">
                <h4>{{ $weekH }} <span style="font-size:.85rem;font-weight:500;color:var(--muted);">/ {{$weekTarget}}س</span></h4>
                <small>ساعات الأسبوع</small>
                <div class="bar-track mt-1" style="height:4px;border-radius:10px;background:rgba(0,0,0,.07);overflow:hidden;">
                    <div style="height:100%;border-radius:10px;width:{{$weekPercent}}%;background:var(--o);transition:width .7s;"></div>
                </div>
            </div>
        </div>
        <div class="sum-card">
            <div class="sum-icon" style="background:var(--g-pale);color:var(--g);"><i class="fa fa-calendar"></i></div>
            <div class="sum-body">
                <h4>{{ $monthH }} <span style="font-size:.85rem;font-weight:500;color:var(--muted);">/ {{$monthTarget}}س</span></h4>
                <small>ساعات الشهر</small>
                <div class="bar-track mt-1" style="height:4px;border-radius:10px;background:rgba(0,0,0,.07);overflow:hidden;">
                    <div style="height:100%;border-radius:10px;width:{{$monthPercent}}%;background:var(--g);transition:width .7s;"></div>
                </div>
            </div>
        </div>
        <div class="sum-card">
            <div class="sum-icon" style="background:var(--c-pale);color:var(--c);"><i class="fa fa-users"></i></div>
            <div class="sum-body">
                <h4>{{ isset($rows) ? $rows->total() : 0 }}</h4>
                <small>إجمالي السجلات</small>
            </div>
        </div>
    </div>

    {{-- ══ STATS + TIMELINE ══ --}}
    <div class="row mb-3 g-3">
        <div class="col-md-6 anim ad-3">
            <div class="ac">
                <div class="ac-head"><h5><i class="fa fa-bar-chart" style="color:var(--p);"></i> إحصائيات الحضور</h5></div>
                <div class="ac-body">
                    <div class="stat-row">
                        <div class="sr-lbl"><span>⏱ اليوم</span><strong>{{ $todayH }} / {{ $dayTarget }} ساعة</strong></div>
                        <div class="bar-track"><div class="bar-fill" style="width:{{$dayPercent}}%;background:var(--p);"></div></div>
                    </div>
                    <div class="stat-row">
                        <div class="sr-lbl"><span>📅 هذا الأسبوع</span><strong>{{ $weekH }} / {{ $weekTarget }} ساعة</strong></div>
                        <div class="bar-track"><div class="bar-fill" style="width:{{$weekPercent}}%;background:var(--o);"></div></div>
                    </div>
                    <div class="stat-row">
                        <div class="sr-lbl"><span>🗓 هذا الشهر</span><strong>{{ $monthH }} / {{ $monthTarget }} ساعة</strong></div>
                        <div class="bar-track"><div class="bar-fill" style="width:{{$monthPercent}}%;background:var(--g);"></div></div>
                    </div>
                    <div class="stat-row">
                        <div class="sr-lbl"><span>⭐ وقت إضافي</span><strong>-</strong></div>
                        <div class="bar-track"><div class="bar-fill" style="width:0%;background:var(--c);"></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 anim ad-4">
            <div class="ac">
                <div class="ac-head"><h5><i class="fa fa-history" style="color:var(--v);"></i> آخر النشاطات</h5></div>
                <div class="ac-body">
                    @php
                        $avColors = [
                            'linear-gradient(135deg,#2563eb,#60a5fa)',
                            'linear-gradient(135deg,#059669,#34d399)',
                            'linear-gradient(135deg,#d97706,#fbbf24)',
                            'linear-gradient(135deg,#dc2626,#f87171)',
                            'linear-gradient(135deg,#7c3aed,#c4b5fd)',
                            'linear-gradient(135deg,#0891b2,#67e8f9)',
                        ];
                    @endphp
                    <div class="tl-wrap">
                        @if(isset($rows) && $rows->count())
                            @foreach($rows->take(6) as $idx => $r)
                            @php
                                $d2   = \Carbon\Carbon::parse($r->day_date);
                                $in2  = $r->check_in  ? \Carbon\Carbon::parse($r->check_in)  : null;
                                $out2 = $r->check_out ? \Carbon\Carbon::parse($r->check_out) : null;
                                $ac   = $avColors[$idx % 6];
                                $name = $r->employee_name ?? 'موظف #' . $r->user_id;
                            @endphp
                            <div class="tl-item">
                                <div class="tl-dot" style="background:{{ $ac }}; color:#fff; font-weight:700; font-size:12px;">
                                    {{ mb_substr($name, 0, 1) }}
                                </div>
                                <div class="tl-info">
                                    <div class="name">{{ $name }} — {{ $d2->locale('ar')->isoFormat('D MMM') }}</div>
                                    <div class="time">
                                        <i class="fa fa-sign-in" style="color:var(--g);"></i>
                                        {{ $in2 ? $in2->format('h:i A') : '-' }}
                                        &nbsp;
                                        <i class="fa fa-sign-out" style="color:var(--r);"></i>
                                        {{ $out2 ? $out2->format('h:i A') : '-' }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-att"><i class="fa fa-inbox"></i><p>لا توجد بيانات</p></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER BAR ══ --}}
    <form method="GET" class="filter-bar anim ad-4">
        <div class="fg">
            <label><i class="fa fa-calendar"></i> التاريخ</label>
            <input name="date" type="date" value="{{ request('date') }}">
        </div>
        <div class="fg">
            <label><i class="fa fa-calendar-o"></i> الشهر</label>
            <select name="month">
                <option value="">كل الأشهر</option>
                @php $months=['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر']; @endphp
                @foreach($months as $mi => $mn)
                    <option value="{{ $mi+1 }}" @selected(request('month') == $mi+1)>{{ $mn }}</option>
                @endforeach
            </select>
        </div>
        <div class="fg">
            <label><i class="fa fa-sort-numeric-desc"></i> السنة</label>
            <select name="year">
                <option value="">كل السنوات</option>
                @for($y = date('Y'); $y >= date('Y')-10; $y--)
                    <option value="{{ $y }}" @selected(request('year') == $y)>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn-search">
            <i class="fa fa-search"></i> بحث
        </button>
        <a href="{{ request()->url() }}" style="font-size:.8rem;color:var(--muted);align-self:center;text-decoration:none;margin-top:2px;">
            <i class="fa fa-times"></i> إعادة تعيين
        </a>
    </form>

    {{-- ══ ATTENDANCE TABLE ══ --}}
    <div class="att-table-wrap anim ad-5">
        <div class="att-table-head">
            <h5>
                <i class="fa fa-table" style="color:var(--p);font-size:.85rem;"></i>
                سجلات الحضور والانصراف
                @if(isset($rows) && $rows->count())
                    <span style="font-size:.75rem;font-weight:600;padding:2px 9px;border-radius:20px;background:var(--p-pale);color:var(--p);">
                        {{ $rows->total() }} سجل
                    </span>
                @endif
            </h5>
            <div style="font-size:.75rem;color:var(--muted);display:flex;gap:12px;align-items:center;">
                <span><span class="att-status present" style="padding:2px 7px;">●</span> حضر في الوقت</span>
                <span><span class="att-status late"    style="padding:2px 7px;">●</span> تأخر</span>
                <span><span class="att-status incomplete" style="padding:2px 7px;">●</span> ناقص</span>
                <span><span class="att-status absent"  style="padding:2px 7px;">●</span> غائب</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="att-table">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>الموظف</th>
                        <th>رقم البصمة</th>
                        <th>التاريخ</th>
                        <th>اليوم</th>
                        <th>⬇ وقت الدخول</th>
                        <th>⬆ وقت الخروج</th>
                        <th>⏱ مدة العمل</th>
                        <th style="text-align:center;">الحالة</th>
                        <th>ملاحظة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $i => $row)
                    @php
                        $inT  = $row->check_in  ? \Carbon\Carbon::parse($row->check_in)  : null;
                        $outT = $row->check_out ? \Carbon\Carbon::parse($row->check_out) : null;
                        $dayC = \Carbon\Carbon::parse($row->day_date);

                        $prodMins  = ($inT && $outT) ? $inT->diffInMinutes($outT) : 0;
                        $prodHours = $prodMins ? round($prodMins / 60, 2) : 0;

                        // حساب الحالة
                        $workStart = \Carbon\Carbon::parse($row->day_date . ' 08:00:00');
                        if (!$inT) {
                            $status = 'absent';
                        } elseif (!$outT || $row->punch_count < 2) {
                            $status = 'incomplete';
                        } elseif ($inT->gt($workStart->copy()->addMinutes(15))) {
                            $status = 'late';
                        } else {
                            $status = 'present';
                        }

                        $statusLabels = ['present' => 'حضر', 'late' => 'متأخر', 'absent' => 'غائب', 'incomplete' => 'ناقص'];
                        $statusIcons  = ['present' => '✅',   'late' => '⚠️',    'absent' => '❌',    'incomplete' => '⏳'];

                        $avatarColors = [
                            'linear-gradient(135deg,#2563eb,#60a5fa)',
                            'linear-gradient(135deg,#059669,#34d399)',
                            'linear-gradient(135deg,#d97706,#fbbf24)',
                            'linear-gradient(135deg,#dc2626,#f87171)',
                            'linear-gradient(135deg,#7c3aed,#c4b5fd)',
                            'linear-gradient(135deg,#0891b2,#67e8f9)',
                        ];

                        $empName     = $row->employee_name ?? 'موظف #' . $row->user_id;
                        $ac2         = $avatarColors[$row->user_id % 6];
                        $lateMinutes = ($inT && $inT->gt($workStart)) ? $inT->diffInMinutes($workStart) : 0;

                        if ($prodHours >= 8)     $hClass = 'full';
                        elseif ($prodHours >= 4) $hClass = 'partial';
                        else                     $hClass = 'zero';

                        $dayName   = $dayC->locale('ar')->isoFormat('dddd');
                        $isWeekend = in_array($dayC->dayOfWeek, [5, 6]);
                    @endphp
                    <tr @if($isWeekend) style="background:rgba(124,58,237,.025);" @endif>
                        <td><span class="row-num">{{ $rows->firstItem() + $i }}</span></td>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-av" style="background:{{ $ac2 }};">{{ mb_substr($empName, 0, 1) }}</div>
                                <span class="emp-name">{{ $empName }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:.78rem;font-weight:600;padding:3px 8px;background:var(--p-pale);color:var(--p);border-radius:6px;">
                                #{{ $row->user_id }}
                            </span>
                        </td>
                        <td style="white-space:nowrap;">
                            <span style="font-weight:600;color:var(--txt);">{{ $dayC->format('d') }}</span>
                            <span style="color:var(--muted);font-size:.8rem;"> {{ $dayC->locale('ar')->isoFormat('MMM YYYY') }}</span>
                        </td>
                        <td>
                            <span style="font-size:.78rem;color:{{ $isWeekend ? 'var(--v)' : 'var(--muted)' }};font-weight:{{ $isWeekend ? '700' : '500' }};">
                                {{ $dayName }}
                            </span>
                        </td>
                        <td>
                            @if($inT)
                                <span class="t-badge in">
                                    <i class="fa fa-sign-in"></i> {{ $inT->format('h:i A') }}
                                </span>
                                @if($lateMinutes > 15)
                                    <span style="font-size:.7rem;color:var(--o);margin-right:4px;">+{{ $lateMinutes }}د</span>
                                @endif
                            @else
                                <span class="t-badge dash">—</span>
                            @endif
                        </td>
                        <td>
                            @if($outT && $row->punch_count >= 2)
                                <span class="t-badge out">
                                    <i class="fa fa-sign-out"></i> {{ $outT->format('h:i A') }}
                                </span>
                            @else
                                <span class="t-badge dash">—</span>
                            @endif
                        </td>
                        <td>
                            @if($prodHours > 0 && $row->punch_count >= 2)
                                <span class="h-pill {{ $hClass }}">{{ $prodHours }} س</span>
                            @else
                                <span class="t-badge dash">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <span class="att-status {{ $status }}">
                                {{ $statusIcons[$status] }} {{ $statusLabels[$status] }}
                            </span>
                        </td>
                        <td style="font-size:.78rem;color:var(--muted);">
                            @if($isWeekend)
                                <span style="color:var(--v);">عطلة</span>
                            @elseif($status === 'late' && $lateMinutes > 0)
                                تأخر {{ $lateMinutes }} دقيقة
                            @elseif($status === 'incomplete')
                                بصمة واحدة فقط ({{ $row->punch_count }})
                            @elseif($status === 'absent')
                                لا يوجد سجل
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-att">
                                <i class="fa fa-calendar-times-o"></i>
                                <p>لا توجد سجلات حضور للفترة المحددة</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($rows) && $rows->hasPages())
        <div class="att-pagination">
            {{ $rows->links() }}
        </div>
        @endif

    </div>

</div>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', loadStatus);

const el = {
    lastLog:   document.getElementById('zk-last-log'),
    total:     document.getElementById('zk-total'),
    btn:       document.getElementById('zk-sync-btn'),
    icon:      document.getElementById('zk-icon'),
    pbar:      document.getElementById('sync-pbar'),
    fill:      document.getElementById('sync-fill'),
    resultBox: document.getElementById('sync-result-box'),
    inner:     document.getElementById('sr-inner'),
    ip:        document.getElementById('zk-ip'),
    running:   document.getElementById('zk-running-badge'),
};

async function loadStatus() {
    try {
        const res  = await fetch("{{ route('zk.status') }}");
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();
        el.lastLog.innerHTML = data.last_log ?? '-';
        el.total.textContent = data.total    ?? '-';
        if (data.is_running) {
            el.btn.disabled          = true;
            el.icon.className        = 'fa fa-spinner fa-spin';
            el.running.style.display = 'inline-block';
        }
    } catch {
        el.lastLog.innerHTML = '<span style="opacity:.7">تعذر الجلب</span>';
    }
}

async function zkSync() {
    const ip = el.ip.value.trim();
    if (!ip) { showResult(false, 'الرجاء إدخال IP الجهاز أولاً', null); return; }

    setLoading(true);
    animateProgress();

    try {
        const res  = await fetch("{{ route('zk.sync') }}", {
            method : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ ip }),
        });
        const data = await res.json();
        showResult(data.success, data.message, data.details ?? null);
        if (data.success) { loadStatus(); setTimeout(() => location.reload(), 2200); }
    } catch (err) {
        showResult(false, 'فشل الاتصال: ' + err.message, null);
    } finally {
        setLoading(false);
    }
}

function showResult(ok, msg, details) {
    el.resultBox.style.display = 'block';
    el.inner.className = ok ? 'sr-inner' : 'sr-inner err';
    let html = `<strong>${ok ? '✅' : '❌'} ${msg}</strong>`;
    if (ok && details) {
        html += `
        <div class="sr-stats">
            <div class="sr-stat"><div class="sv">${details.total_logs ?? 0}</div><div class="sl">سجلات مسحوبة</div></div>
            <div class="sr-stat"><div class="sv">${details.new_logs   ?? 0}</div><div class="sl">سجلات جديدة</div></div>
            <div class="sr-stat"><div class="sv">${details.new_users  ?? 0}</div><div class="sl">موظفون</div></div>
            <div class="sr-stat"><div class="sv">${details.duration   ?? '-'}</div><div class="sl">مدة المزامنة</div></div>
        </div>`;
        html += '<div style="margin-top:8px;font-size:.75rem;opacity:.8;">🔄 جاري تحديث الصفحة…</div>';
    }
    el.inner.innerHTML = html;
}

function setLoading(state) {
    el.btn.disabled           = state;
    el.icon.className         = state ? 'fa fa-spinner fa-spin' : 'fa fa-refresh';
    el.pbar.style.display     = state ? 'block' : 'none';
    el.running.style.display  = state ? 'inline-block' : 'none';
    if (state) { el.resultBox.style.display = 'none'; el.fill.style.width = '0%'; }
}

function animateProgress() {
    let p = 0;
    const t = setInterval(() => {
        p += Math.random() * 8;
        if (p >= 90) { clearInterval(t); p = 90; }
        el.fill.style.width = p + '%';
    }, 300);
    window._progTimer = t;
}
</script>
@endsection
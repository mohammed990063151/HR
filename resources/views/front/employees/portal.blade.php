<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>بوابة الموظف — الحضور والانصراف</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
    --bg:#f4f6fa;--bg2:#ffffff;--bg3:#f8f9fc;--card:#ffffff;--border:#e8ebf2;
    --txt:#1f2937;--muted:#6b7280;--accent:#4263eb;--green:#16a34a;--red:#dc2626;--orange:#ea580c;--yellow:#ca8a04;
    --radius:12px;--shadow:0 4px 20px rgba(17,24,39,.06);
}
html{font-size:15px;}
body{background:var(--bg);color:var(--txt);font-family:'Cairo','Segoe UI',Tahoma,Arial,sans-serif;min-height:100vh;direction:rtl;}
.page-wrap{width:100%;max-width:min(1680px,100%);margin:0 auto;padding:clamp(12px,2.5vw,32px);padding-bottom:calc(72px + env(safe-area-inset-bottom,0));}
.portal-header{background:#fff;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;padding-top:env(safe-area-inset-top,0);}
.portal-header-top{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 16px;flex-wrap:wrap;}
.portal-header .logo{font-size:1.1rem;font-weight:700;color:var(--txt);text-decoration:none;}
.portal-header .logo span{color:var(--accent);}
.emp-badge{display:flex;align-items:center;gap:10px;background:var(--bg3);border:1px solid var(--border);border-radius:50px;padding:8px 14px 8px 10px;max-width:100%;}
.emp-name{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:min(200px,45vw);font-size:.9rem;}
.emp-av{flex-shrink:0;width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),#a259f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.95rem;}
.portal-nav{display:flex;flex-wrap:wrap;align-items:center;gap:6px;padding:8px 16px 12px;border-top:1px solid var(--border);background:#fff;}
.portal-nav .nav-link{display:inline-flex;align-items:center;gap:6px;padding:10px 12px;border-radius:8px;font-size:.82rem;font-weight:600;color:var(--muted);text-decoration:none;min-height:44px;}
.portal-nav .nav-link:hover,.portal-nav .nav-link:focus-visible{background:#eef2ff;color:var(--txt);outline:none;}
.portal-nav .nav-link-active{background:var(--bg3);color:var(--accent);}
.portal-nav .nav-admin{color:#9ab0ff;}
.portal-nav .nav-logout{color:var(--red);}
.main-grid{display:grid;grid-template-columns:1fr;gap:clamp(14px,2vw,28px);margin-top:clamp(12px,2vw,20px);align-items:start;}
@media (min-width: 1200px){
    .main-grid{grid-template-columns:minmax(0,1fr) minmax(300px,380px);}
}
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:24px;}
.card-title{font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-bottom:18px;}
.att-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:28px 24px;}
.att-status-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
.status-pill{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:50px;font-size:.82rem;font-weight:700;}
.status-pill.in{background:rgba(34,201,122,.15);color:var(--green);border:1px solid rgba(34,201,122,.25);}
.status-pill.out{background:rgba(240,82,82,.12);color:var(--red);border:1px solid rgba(240,82,82,.2);}
.status-pill.idle{background:rgba(122,127,146,.1);color:var(--muted);border:1px solid var(--border);}
.time-display{text-align:center;margin-bottom:24px;}
.time-display .now{font-size:clamp(1.75rem,8vw,2.8rem);font-weight:700;letter-spacing:-.02em;line-height:1;}
.time-display .date{color:var(--muted);font-size:.85rem;margin-top:4px;}
.checkin-times{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;}
@media(max-width:400px){.checkin-times{grid-template-columns:1fr;}}
.time-box{background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center;}
.time-box .label{font-size:.72rem;color:var(--muted);font-weight:600;margin-bottom:6px;}
.time-box .val{font-size:1.3rem;font-weight:700;}
.time-box.in .val{color:var(--green);}.time-box.out .val{color:var(--red);}
.location-bar{display:flex;align-items:center;gap:10px;background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:.82rem;}
.loc-badge{font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:50px;}
.loc-badge.allowed{background:rgba(34,201,122,.15);color:var(--green);}
.loc-badge.denied{background:rgba(240,82,82,.12);color:var(--red);}
.loc-badge.loading{background:rgba(122,127,146,.1);color:var(--muted);}
.loc-badge.neutral{background:rgba(91,158,245,.12);color:#8eb4ff;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 20px;min-height:48px;border-radius:10px;font-size:.92rem;font-weight:700;border:none;cursor:pointer;width:100%;font-family:inherit;touch-action:manipulation;}
.btn:disabled{opacity:.4;cursor:not-allowed;}
.att-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
@media(max-width:480px){.att-actions{grid-template-columns:1fr;}}
.btn-checkin{background:var(--green);color:#fff;}
.btn-checkout{background:var(--red);color:#fff;}
.btn-secondary{background:var(--bg3);color:var(--txt);border:1px solid var(--border);}
.btn-accent{background:var(--accent);color:#fff;}
.stats-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:20px;}
@media(min-width:900px){.stats-grid{grid-template-columns:repeat(4,1fr);}}
.stat-box{background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:14px 16px;}
.stat-box .s-label{font-size:.72rem;color:var(--muted);font-weight:600;margin-bottom:4px;}
.stat-box .s-val{font-size:1.6rem;font-weight:700;}
.stat-box.green .s-val{color:var(--green);}.stat-box.orange .s-val{color:var(--orange);}
.stat-box.red .s-val{color:var(--red);}.stat-box.blue .s-val{color:#5b9ef5;}
.new-chip{
    display:inline-flex;
    align-items:center;
    gap:4px;
    margin-right:6px;
    padding:2px 8px;
    border-radius:999px;
    font-size:.64rem;
    font-weight:700;
    color:#fff;
    background:linear-gradient(135deg,#22c55e,#16a34a);
}
.tab-bar{display:flex;gap:4px;background:var(--bg3);border-radius:10px;padding:4px;margin-bottom:20px;}
.tab-btn{flex:1;padding:9px;border-radius:8px;border:none;background:transparent;color:var(--muted);font-size:.8rem;font-weight:600;cursor:pointer;font-family:inherit;}
.tab-btn.active{background:var(--card);color:var(--txt);box-shadow:0 1px 6px rgba(0,0,0,.3);}
.tab-panel{display:none;}.tab-panel.active{display:block;}
.form-group{margin-bottom:14px;}
.form-group label{display:block;font-size:.78rem;color:var(--muted);font-weight:600;margin-bottom:6px;}
.form-control{width:100%;background:var(--bg3);border:1px solid var(--border);border-radius:8px;padding:10px 12px;color:var(--txt);font-size:.85rem;font-family:inherit;}
textarea.form-control{resize:vertical;min-height:80px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.req-item{display:flex;align-items:center;gap:12px;padding:12px;background:var(--bg3);border:1px solid var(--border);border-radius:10px;margin-bottom:8px;}
.att-table{width:100%;border-collapse:collapse;font-size:.82rem;}
.att-table th{text-align:right;padding:10px 14px;background:var(--bg3);color:var(--muted);font-weight:700;font-size:.72rem;border-bottom:1px solid var(--border);}
.att-table td{padding:12px 14px;border-bottom:1px solid rgba(255,255,255,.04);}
.s-badge{display:inline-flex;padding:4px 10px;border-radius:50px;font-size:.72rem;font-weight:700;}
.s-badge.present{background:rgba(34,201,122,.15);color:var(--green);}
.s-badge.late{background:rgba(240,146,46,.12);color:var(--orange);}
.s-badge.absent{background:rgba(240,82,82,.12);color:var(--red);}
#toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(80px);background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:14px 20px;display:flex;align-items:center;gap:10px;font-size:.85rem;font-weight:600;z-index:9999;transition:transform .35s;box-shadow:var(--shadow);min-width:260px;}
#toast.show{transform:translateX(-50%) translateY(0);}
.spinner{width:18px;height:18px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none;}
@keyframes spin{to{transform:rotate(360deg);}}
.loading .spinner{display:inline-block;}.loading .btn-text{display:none;}
.month-filter{display:flex;gap:8px;align-items:center;margin-bottom:16px;flex-wrap:wrap;}
.empty-state{text-align:center;padding:40px;color:var(--muted);}
#portal-map{height:clamp(220px,32vh,360px);min-height:220px;width:100%;background:var(--bg3);border-radius:8px;z-index:1;}
#portal-map .leaflet-container{font-family:inherit;background:var(--bg3);}
.att-table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;border-radius:8px;border:1px solid var(--border);}
/* خرائط Leaflet داخل صفحة RTL */
.leaflet-container{direction:ltr;}
/* تحسين إضافي للشاشات المتوسطة */
@media (max-width: 1200px){
    .portal-nav{gap:4px;}
    .portal-nav .nav-link{padding:9px 10px;font-size:.79rem;}
}
@media (max-width: 900px){
    .page-wrap{padding:12px;}
    .portal-header-top{padding:10px 12px;}
    .portal-nav{
        overflow-x:auto;
        white-space:nowrap;
        flex-wrap:nowrap;
        padding:8px 12px 10px;
    }
    .portal-nav .nav-link{flex:0 0 auto;}
    .main-grid{gap:14px;}
    .card,.att-card{padding:16px;}
    .time-display .now{font-size:2rem;}
    #portal-map{height:260px;}
    .form-row{grid-template-columns:1fr;}
    .att-table{font-size:.78rem;}
    .att-table th,.att-table td{padding:9px 10px;}
}
@media (max-width: 576px){
    .page-wrap{padding:8px;}
    .emp-badge{width:100%;justify-content:center;}
    .portal-header .logo{width:100%;text-align:center;}
    .att-status-row{flex-direction:column;align-items:flex-start;gap:8px;}
    .month-filter .form-control{width:100% !important;}
    .month-filter .btn{width:100% !important;}
    .req-item{padding:10px;gap:10px;}
    .req-item > div:last-child{min-width:0;}
    .tab-btn{font-size:.76rem;padding:8px 6px;}
    .time-box .val{font-size:1.08rem;}
    .stats-grid{grid-template-columns:1fr 1fr;}
    .att-actions .btn{font-size:.85rem;min-height:44px;padding:10px 12px;}
    #portal-map{height:220px;}
    .card-title{font-size:.74rem;}
    #toast{left:12px;right:12px;min-width:0;transform:translateY(80px);}
    #toast.show{transform:translateY(0);}
}
@media (max-width: 380px){
    .portal-nav .nav-link{padding:8px 9px;font-size:.74rem;}
    .portal-header-top{gap:8px;}
    .emp-av{width:30px;height:30px;font-size:.82rem;}
}
</style>
</head>
<body>

<header class="portal-header">
    <div class="portal-header-top">
        <a href="{{ route('portal.index') }}" class="logo">بوابة <span>الموظف</span></a>
        <div class="emp-badge">
            <div class="emp-av">{{ mb_substr($employeeName, 0, 1) }}</div>
            <span class="emp-name">{{ $employeeName }}</span>
        </div>
    </div>
    <nav class="portal-nav" aria-label="التنقل الرئيسي">
        <a href="{{ route('home') }}" class="nav-link"><i class="fa fa-house"></i> الرئيسية</a>
        <a href="{{ route('portal.index') }}" class="nav-link nav-link-active"><i class="fa fa-id-badge"></i> البوابة</a>
        <a href="{{ route('portal.attendance-board') }}" class="nav-link"><i class="fa fa-calendar-days"></i> صفحة الحضور</a>
        <a href="{{ route('profile_user') }}" class="nav-link"><i class="fa fa-user"></i> الملف الشخصي</a>
        @if(!empty($showAdminNav))
            <a href="{{ route('admin.locations.index') }}" class="nav-link nav-admin"><i class="fa fa-map-location-dot"></i> المواقع</a>
            <a href="{{ route('admin.requests.index') }}" class="nav-link nav-admin"><i class="fa fa-inbox"></i> طلبات الموظفين</a>
            <a href="{{ route('admin.attendance.index') }}" class="nav-link nav-admin"><i class="fa fa-calendar-check"></i> حضور الموظفين</a>
        @endif
        <a href="{{ route('logout') }}" class="nav-link nav-logout"><i class="fa fa-right-from-bracket"></i> خروج</a>
    </nav>
</header>

<div class="page-wrap">
<div class="main-grid">

<div>
    <div class="att-card" style="margin-bottom:20px;">
        <div class="att-status-row">
            <span class="card-title" style="margin-bottom:0;">سجل اليوم</span>
            @php
                $checkedIn  = $todayRecord && $todayRecord->check_in;
                $checkedOut = $todayRecord && $todayRecord->check_out;
            @endphp
            @if($checkedIn && !$checkedOut)
                <span class="status-pill in"><span class="dot"></span> في العمل</span>
            @elseif($checkedIn && $checkedOut)
                <span class="status-pill out"><i class="fa fa-check" style="font-size:.7rem;"></i> انصرفت</span>
            @else
                <span class="status-pill idle">لم يُسجَّل بعد</span>
            @endif
        </div>

        <div class="time-display">
            <div class="now" id="live-clock">--:--:--</div>
            <div class="date" id="live-date">---</div>
        </div>

        <div class="checkin-times">
            <div class="time-box in">
                <div class="label"><i class="fa fa-sign-in-alt"></i> وقت الدخول</div>
                <div class="val" id="ci-time">{{ $checkedIn ? $todayRecord->check_in->format('h:i A') : '—' }}</div>
            </div>
            <div class="time-box out">
                <div class="label"><i class="fa fa-sign-out-alt"></i> وقت الخروج</div>
                <div class="val" id="co-time">{{ $checkedOut ? $todayRecord->check_out->format('h:i A') : '—' }}</div>
            </div>
        </div>

        <div class="location-bar" id="loc-bar">
            <span class="loc-icon"><i class="fa fa-location-dot"></i></span>
            <span class="loc-text" id="loc-text">جارٍ تحديد موقعك...</span>
            <span class="loc-badge loading" id="loc-badge"><i class="fa fa-circle-notch fa-spin" style="font-size:.65rem;"></i> جارٍ التحقق</span>
        </div>
        <button type="button" class="btn btn-secondary" id="btn-locate-now" style="margin-bottom:16px;" onclick="locateNow()">
            <i class="fa fa-location-crosshairs"></i> موقعي الآن
        </button>

        <div class="card" style="margin-bottom:16px;padding:0;overflow:hidden;border:1px solid var(--border);">
            <div style="padding:12px 16px;font-size:.75rem;font-weight:700;color:var(--muted);">الخريطة</div>
            <div id="portal-map"></div>
        </div>

        <div class="att-actions">
            <button class="btn btn-checkin" id="btn-checkin" {{ $checkedIn ? 'disabled' : '' }} onclick="doCheckIn()">
                <span class="btn-text"><i class="fa fa-fingerprint"></i> تسجيل حضور</span>
                <span class="spinner"></span>
            </button>
            <button class="btn btn-checkout" id="btn-checkout" {{ (!$checkedIn || $checkedOut) ? 'disabled' : '' }} onclick="doCheckOut()">
                <span class="btn-text"><i class="fa fa-right-from-bracket"></i> تسجيل انصراف</span>
                <span class="spinner"></span>
            </button>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="card-title">إحصائيات هذا الشهر</div>
        <div class="stats-grid">
            <div class="stat-box green">
                <div class="s-label">الرصيد المستحق <span class="new-chip"><i class="fa fa-star"></i> جديد</span></div>
                <div class="s-val">{{ $stats->deserved_balance ?? 0 }}</div>
            </div>
            <div class="stat-box blue">
                <div class="s-label">الرصيد المتبقي <span class="new-chip"><i class="fa fa-star"></i> جديد</span></div>
                <div class="s-val">{{ $stats->remaining_balance ?? 0 }}</div>
            </div>
            <div class="stat-box red"><div class="s-label">سجلات غير مكتملة</div><div class="s-val">{{ $stats->incomplete_days ?? 0 }}</div></div>
            <div class="stat-box orange"><div class="s-label">إجمالي السجلات</div><div class="s-val">{{ $stats->total_days ?? 0 }}</div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">سجل الحضور</div>
        <form method="GET" class="month-filter">
            <select name="month" class="form-control" style="width:auto;">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $m }}</option>
                @endfor
            </select>
            <select name="year" class="form-control" style="width:auto;">
                @for($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-secondary" style="width:auto;padding:9px 18px;"><i class="fa fa-filter"></i> تصفية</button>
        </form>

        @if($attendance->isEmpty())
            <div class="empty-state"><i class="fa fa-calendar-xmark"></i><br>لا توجد سجلات لهذه الفترة</div>
        @else
        <div class="att-table-wrap">
        <table class="att-table">
            <thead>
                <tr>
                    <th>التاريخ</th><th>اليوم</th><th>الدخول</th><th>الخروج</th><th>المدة</th><th>الحالة</th>
                </tr>
            </thead>
            <tbody>
            @foreach($attendance as $row)
            @php
                $d   = \Carbon\Carbon::parse($row->date);
                $inT = $row->check_in  ? \Carbon\Carbon::parse($row->check_in)  : null;
                $ouT = $row->check_out ? \Carbon\Carbon::parse($row->check_out) : null;
                $hrs = ($inT && $ouT) ? round($inT->diffInMinutes($ouT) / 60, 1) : ($row->working_hours ?? null);
                $statusLabels = ['present'=>'حضور','late'=>'متأخر','absent'=>'غائب'];
            @endphp
            <tr>
                <td style="font-weight:600;">{{ $d->format('d') }} <span style="color:var(--muted);font-size:.78rem;">{{ $d->locale('ar')->isoFormat('MMM') }}</span></td>
                <td style="color:var(--muted);font-size:.8rem;">{{ $d->locale('ar')->isoFormat('dddd') }}</td>
                <td style="color:var(--green);font-weight:600;">{{ $inT ? $inT->format('h:i A') : '—' }}</td>
                <td style="color:var(--red);font-weight:600;">{{ $ouT ? $ouT->format('h:i A') : '—' }}</td>
                <td style="color:var(--muted);">{{ $hrs ? $hrs.' س' : '—' }}</td>
                <td><span class="s-badge {{ $row->status }}">{{ $statusLabels[$row->status] ?? $row->status }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
</div>

<div>
    <div class="card" style="margin-bottom:20px;">
        <div class="card-title">فترات العمل المعتمدة</div>
        @forelse($workPeriods as $period)
            <div class="req-item">
                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(66,99,235,.12);color:var(--accent);">
                    <i class="fa fa-clock"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-weight:700;font-size:.88rem;">{{ $period->title }}</div>
                    <div style="font-size:.76rem;color:var(--muted);">{{ \Carbon\Carbon::createFromFormat('H:i:s',$period->from_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s',$period->to_time)->format('h:i A') }}</div>
                </div>
            </div>
        @empty
            <div class="empty-state py-3">لا توجد فترات عمل مضافة من الإدارة</div>
        @endforelse
    </div>

    <div class="card">
        <div class="card-title">الطلبات</div>
        <div class="tab-bar">
            <button type="button" class="tab-btn active" onclick="switchTab('new', this)">طلب جديد</button>
            <button type="button" class="tab-btn" onclick="switchTab('list', this)">طلباتي ({{ $requests->count() }})</button>
            <button type="button" class="tab-btn" onclick="switchTab('report', this)">التقارير</button>
        </div>

        <div class="tab-panel active" id="tab-new">
            <div class="form-group">
                <label>نوع الطلب</label>
                <select class="form-control" id="req-type" onchange="toggleTimeFields()">
                    <option value="permission">استئذان</option>
                    <option value="late">تأخير دخول</option>
                    <option value="absence">غياب</option>
                </select>
            </div>
            <div class="form-group">
                <label>التاريخ</label>
                <input type="date" class="form-control" id="req-date" min="{{ today()->format('Y-m-d') }}" value="{{ today()->format('Y-m-d') }}">
            </div>
            <div class="form-row" id="time-fields">
                <div class="form-group">
                    <label>من الساعة</label>
                    <input type="time" class="form-control" id="req-from">
                </div>
                <div class="form-group">
                    <label>إلى الساعة</label>
                    <input type="time" class="form-control" id="req-to">
                </div>
            </div>
            <div class="form-group">
                <label>السبب</label>
                <textarea class="form-control" id="req-reason" placeholder="اكتب سبب الطلب بوضوح..."></textarea>
            </div>
            <button class="btn btn-accent" id="btn-send-req" onclick="submitRequest()">
                <span class="btn-text"><i class="fa fa-paper-plane"></i> إرسال الطلب</span>
                <span class="spinner"></span>
            </button>
        </div>

        <div class="tab-panel" id="tab-list">
            @if($requests->isEmpty())
                <div class="empty-state"><i class="fa fa-inbox"></i><br>لا توجد طلبات بعد</div>
            @else
                @foreach($requests as $req)
                @php
                    $icons = ['permission' => 'fa-clock', 'late' => 'fa-hourglass-start', 'absence' => 'fa-user-xmark'];
                @endphp
                <div class="req-item">
                    <div class="req-icon {{ $req->type }}" style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(91,110,245,.15);color:var(--accent);">
                        <i class="fa {{ $icons[$req->type] ?? 'fa-file' }}"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.8rem;font-weight:700;">{{ $req->typeLabel() }}</div>
                        <div style="font-size:.72rem;color:var(--muted);">
                            {{ \Carbon\Carbon::parse($req->date)->locale('ar')->isoFormat('D MMM YYYY') }}
                            @if($req->from_time) · {{ $req->from_time }} - {{ $req->to_time }} @endif
                        </div>
                        @if($req->status === 'pending')
                            <div style="font-size:.72rem;color:#6366f1;margin-top:3px;">
                                {{ $req->waitingAtLabel() }}
                            </div>
                        @endif
                        @if($req->admin_note)
                            <div style="font-size:.72rem;color:var(--muted);margin-top:3px;">ملاحظة: {{ $req->admin_note }}</div>
                        @endif
                    </div>
                    <span style="font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:50px;background:rgba(240,197,46,.1);color:var(--yellow);">{{ $req->statusLabel() }}</span>
                </div>
                @endforeach
            @endif
        </div>

        <div class="tab-panel" id="tab-report">
            <div class="req-item">
                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(66,99,235,.12);color:var(--accent);">
                    <i class="fa fa-calendar-day"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:700;font-size:.88rem;">التقرير اليومي</div>
                    <div style="font-size:.78rem;color:var(--muted);">
                        إجمالي السجلات: {{ (int)($todayReport->total ?? 0) }} • غير مكتمل: {{ (int)($todayReport->incomplete ?? 0) }}
                    </div>
                </div>
            </div>
            <div class="req-item">
                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(234,88,12,.12);color:var(--orange);">
                    <i class="fa fa-calendar-week"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:700;font-size:.88rem;">التقرير الأسبوعي</div>
                    <div style="font-size:.78rem;color:var(--muted);">
                        إجمالي: {{ (int)($weekReport->total ?? 0) }} • غياب: {{ (int)($weekReport->absent ?? 0) }} • غير مكتمل: {{ (int)($weekReport->incomplete ?? 0) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-title">الإعلانات</div>
        @forelse($announcements as $ann)
            <div class="req-item">
                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(66,99,235,.12);color:var(--accent);">
                    <i class="fa fa-bullhorn"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-weight:700;font-size:.88rem;">{{ $ann->title }}</div>
                    <div style="font-size:.76rem;color:var(--muted);">{{ $ann->body ?: '—' }}</div>
                </div>
            </div>
        @empty
            <div class="empty-state py-3">لا توجد إعلانات حالياً</div>
        @endforelse
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-title">مناسبات الأسبوع</div>
        @forelse($weeklyOccasions as $occ)
            <div class="req-item">
                <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(234,88,12,.12);color:var(--orange);">
                    <i class="fa fa-gift"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-weight:700;font-size:.88rem;">{{ $occ->title }}</div>
                    <div style="font-size:.76rem;color:var(--muted);">
                        {{ optional($occ->start_date)->format('Y-m-d') ?: '—' }}
                        @if($occ->end_date) - {{ $occ->end_date->format('Y-m-d') }} @endif
                    </div>
                    @if($occ->body)
                        <div style="font-size:.76rem;color:var(--muted);">{{ $occ->body }}</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state py-3">لا توجد مناسبات هذا الأسبوع</div>
        @endforelse
    </div>
</div>

</div>
</div>

<div id="toast"><span class="t-icon" id="t-icon"></span><span id="t-msg"></span></div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
const SERVER_ENFORCE_GEO = @json($serverEnforcesGeo ?? false);
let portalCheckedIn = @json((bool) ($todayRecord && $todayRecord->check_in));
let portalCheckedOut = @json((bool) ($todayRecord && $todayRecord->check_out));
const csrf = document.querySelector('meta[name=csrf-token]').content;
const days = ['الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس','الجمعة','السبت'];
const months = ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
function updateClock(){
    const n = new Date();
    const h = String(n.getHours()).padStart(2,'0');
    const m = String(n.getMinutes()).padStart(2,'0');
    const s = String(n.getSeconds()).padStart(2,'0');
    document.getElementById('live-clock').textContent = `${h}:${m}:${s}`;
    document.getElementById('live-date').textContent = `${days[n.getDay()]}، ${n.getDate()} ${months[n.getMonth()]} ${n.getFullYear()}`;
}
updateClock(); setInterval(updateClock, 1000);

let userLat = null, userLng = null, locationAllowed = false;
let userAccuracy = null, locationCapturedAt = null, hasManualLocate = false;
let portalMap = null, mapFeatureGroup = null;
let cachedLocs = [];
const DEFAULT_MAP_CENTER = [24.7136, 46.6753];

function invalidateMapSize(){
    if(portalMap){
        setTimeout(() => { try { portalMap.invalidateSize(); } catch(e) {} }, 50);
        setTimeout(() => { try { portalMap.invalidateSize(); } catch(e) {} }, 300);
    }
}

function updateMap(locs, uLat, uLng, forceUserFocus = false){
    if(typeof L === 'undefined') return;
    const el = document.getElementById('portal-map');
    if(!el) return;

    const hasUserPoint = Number.isFinite(uLat) && Number.isFinite(uLng);
    const hasAllowedLocations = Array.isArray(locs) && locs.length > 0;
    const cx = hasUserPoint
        ? uLat
        : (hasAllowedLocations ? parseFloat(locs[0].latitude) : DEFAULT_MAP_CENTER[0]);
    const cy = hasUserPoint
        ? uLng
        : (hasAllowedLocations ? parseFloat(locs[0].longitude) : DEFAULT_MAP_CENTER[1]);

    if(!portalMap){
        portalMap = L.map('portal-map', { zoomControl: true }).setView([cx, cy], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; OpenStreetMap'}).addTo(portalMap);
        mapFeatureGroup = L.layerGroup().addTo(portalMap);
    } else {
        portalMap.setView([cx, cy], portalMap.getZoom());
    }

    mapFeatureGroup.clearLayers();

    if(hasAllowedLocations){
        locs.forEach(loc => {
            L.circle([parseFloat(loc.latitude), parseFloat(loc.longitude)], {
                radius: parseFloat(loc.radius_meters), color:'#5b6ef5', fillColor:'#5b6ef5', fillOpacity:0.1, weight:2
            }).addTo(mapFeatureGroup);
            L.marker([parseFloat(loc.latitude), parseFloat(loc.longitude)]).addTo(mapFeatureGroup).bindPopup(loc.name);
        });
    }

    if(hasUserPoint){
        // Marker واضح لموقع الموظف + دائرة دقة
        L.circleMarker([uLat, uLng], {
            radius: 9,
            color: '#ef4444',
            fillColor: '#ef4444',
            fillOpacity: 0.85,
            weight: 2
        }).addTo(mapFeatureGroup).bindPopup('موقعك الحالي');

        if(Number.isFinite(userAccuracy) && userAccuracy > 0){
            L.circle([uLat, uLng], {
                radius: userAccuracy,
                color: '#ef4444',
                fillColor: '#ef4444',
                fillOpacity: 0.08,
                weight: 1
            }).addTo(mapFeatureGroup);
        }
    }

    const b = mapFeatureGroup.getBounds();
    if(forceUserFocus && hasUserPoint){
        portalMap.setView([uLat, uLng], 17);
    } else if(b.isValid()) {
        portalMap.fitBounds(b.pad(0.12));
    } else {
        portalMap.setView([cx, cy], hasUserPoint ? 15 : 6);
    }
    invalidateMapSize();
}

function haversine(lat1,lng1,lat2,lng2){
    const R=6371000,phi1=lat1*Math.PI/180,phi2=lat2*Math.PI/180,
          dp=(lat2-lat1)*Math.PI/180,dl=(lng2-lng1)*Math.PI/180;
    const a=Math.sin(dp/2)**2+Math.cos(phi1)*Math.cos(phi2)*Math.sin(dl/2)**2;
    return R*2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a));
}

function applyAttendanceButtons(){
    const ci = document.getElementById('btn-checkin');
    const co = document.getElementById('btn-checkout');
    if(portalCheckedIn) ci.disabled = true;
    else ci.disabled = false;
    if(!portalCheckedIn || portalCheckedOut) co.disabled = true;
    else co.disabled = false;
}

function applyServerGeoButtonState(){
    const ci = document.getElementById('btn-checkin');
    const co = document.getElementById('btn-checkout');
    if(!SERVER_ENFORCE_GEO){
        applyAttendanceButtons();
        return;
    }
    const blocked = userLat === null || (SERVER_ENFORCE_GEO && !hasManualLocate);
    if(blocked){
        ci.disabled = true;
        co.disabled = true;
        return;
    }
    applyAttendanceButtons();
}

const GEO_OPTIONS = { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 };
const GEO_FAST_OPTIONS = { enableHighAccuracy: false, timeout: 5000, maximumAge: 300000 };
const GEO_FALLBACK_OPTIONS = { enableHighAccuracy: false, timeout: 10000, maximumAge: 120000 };

async function fetchLocations(){
    const res = await fetch('{{ route("portal.locations") }}', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
    if(!res.ok) return [];
    return res.json();
}

async function fetchServerZoneStatus(lat, lng){
    const res = await fetch('{{ route("portal.zone-status") }}', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ latitude: lat, longitude: lng })
    });
    if(!res.ok) throw new Error('ZONE_STATUS_FAILED');
    return res.json();
}

async function resolvePosition(){
    if(!navigator.geolocation){
        throw new Error('GEO_UNSUPPORTED');
    }

    const getPos = (options) => new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject, options);
    });

    // fast first: return cached/network location quickly when available
    try {
        return await getPos(GEO_FAST_OPTIONS);
    } catch (fastErr) {
        try {
            return await getPos(GEO_OPTIONS);
        } catch (accurateErr) {
            // fallback: sometimes high accuracy fails on desktops/weak GPS
            return await getPos(GEO_FALLBACK_OPTIONS);
        }
    }
}

function geolocationErrorMessage(err){
    if(!err) return 'تعذر تحديد موقعك. فعّل GPS/إذن الموقع ثم أعد المحاولة.';
    if(err.code === 1) return 'تم رفض إذن الموقع. اسمح للموقع باستخدام Location من المتصفح.';
    if(err.code === 2) return 'لا يمكن الوصول لخدمة الموقع. تأكد أن GPS وخدمات الموقع مفعلة في النظام.';
    if(err.code === 3) return 'انتهت مهلة تحديد الموقع. جرّب في مكان مفتوح أو مع اتصال أفضل.';
    return 'تعذر تحديد موقعك. فعّل GPS/إذن الموقع ثم أعد المحاولة.';
}

async function checkLocation(){
    let locs = [];
    try {
        locs = await fetchLocations();
    } catch(e) {
        locs = [];
    }
    cachedLocs = locs;

    // اعرض الخريطة دائماً حتى لو لا توجد مواقع معتمدة
    updateMap(locs, userLat, userLng);

    if(!navigator.geolocation){
        setLocBadge(false,'الجهاز لا يدعم تحديد الموقع');
        if(SERVER_ENFORCE_GEO) locationAllowed = false;
        else locationAllowed = true;
        if(SERVER_ENFORCE_GEO) notifyZoneState(false);
        applyServerGeoButtonState();
        return;
    }

    resolvePosition().then(async pos => {
        userLat = pos.coords.latitude;
        userLng = pos.coords.longitude;
        userAccuracy = Number.isFinite(pos.coords.accuracy) ? Math.round(pos.coords.accuracy) : null;
        locationCapturedAt = new Date().toISOString();

        locs = cachedLocs.length ? cachedLocs : await fetchLocations();
        cachedLocs = locs;

        updateMap(locs, userLat, userLng);
        try{
            const serverZone = await fetchServerZoneStatus(userLat, userLng);
            const nearestName = serverZone.nearest_name || '—';
            const nearestDistance = Number.isFinite(serverZone.nearest_distance_m)
                ? `${serverZone.nearest_distance_m}م`
                : '—';

            if(!SERVER_ENFORCE_GEO){
                locationAllowed = true;
                if(serverZone.has_locations){
                    if(serverZone.inside){
                        setLocBadge(true, `داخل نطاق: ${nearestName}`);
                    } else {
                        setLocBadge(true, `أقرب موقع: ${nearestName} (${nearestDistance}) — التسجيل مسموح`);
                    }
                } else {
                    setLocBadgeNeutral('لا توجد مناطق مسموحة مضافة');
                }
                applyServerGeoButtonState();
                return;
            }

            if(!serverZone.has_locations){
                locationAllowed = false;
                setLocBadge(false, 'لا توجد مناطق مسموحة — راجع الإدارة');
                notifyZoneState(false);
                applyServerGeoButtonState();
                return;
            }

            locationAllowed = !!serverZone.inside;
            if(serverZone.inside){
                setLocBadge(true, `داخل نطاق: ${nearestName}`);
                notifyZoneState(true);
            } else {
                setLocBadge(false, `خارج النطاق — أقرب موقع: ${nearestName} (${nearestDistance})`);
                notifyZoneState(false);
            }
            applyServerGeoButtonState();
        } catch(zoneErr){
            // fallback local calculation if server status is unavailable
            if(locs.length === 0){
                if(SERVER_ENFORCE_GEO){
                    setLocBadge(false,'لا توجد مناطق مسموحة — راجع الإدارة');
                    locationAllowed = false;
                    notifyZoneState(false);
                } else {
                    locationAllowed = true;
                    setLocBadgeNeutral('لا دوائر على الخريطة — يمكنك التسجيل بدون GPS');
                }
                applyServerGeoButtonState();
                return;
            }

            let inside = false, nearest = null, minDist = Infinity;
            for(const loc of locs){
                const dist = haversine(userLat,userLng,loc.latitude,loc.longitude);
                if(dist <= loc.radius_meters) inside = true;
                if(dist < minDist){ minDist = dist; nearest = loc; }
            }
            locationAllowed = inside || !SERVER_ENFORCE_GEO;
            if(locationAllowed){
                setLocBadge(true, `داخل نطاق: ${nearest?.name ?? '—'}`);
                if(SERVER_ENFORCE_GEO) notifyZoneState(true);
            } else {
                setLocBadge(false, `خارج النطاق — أقرب موقع: ${nearest?.name ?? '—'} (${Math.round(minDist)}م)`);
                notifyZoneState(false);
            }
            applyServerGeoButtonState();
        }
        // info badge with current accuracy from device
        const acc = Math.round(pos.coords.accuracy || 0);
        if(acc > 0){
            document.getElementById('loc-text').textContent += ` · دقة ±${acc}م`;
        }
    }).catch((err) => {
        const secureContextNeeded = window.location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1';
        const message = secureContextNeeded
            ? 'تعذّر تحديد الموقع: يلزم HTTPS لتفعيل GPS في المتصفح'
            : geolocationErrorMessage(err);
        document.getElementById('loc-text').textContent = message;
        updateMap(cachedLocs, null, null);
        const badge = document.getElementById('loc-badge');
        if(SERVER_ENFORCE_GEO){
            locationAllowed = false;
            badge.className = 'loc-badge denied';
            badge.textContent = '✗ مطلوب الموقع';
            notifyZoneState(false);
        } else {
            locationAllowed = true;
            badge.className = 'loc-badge neutral';
            badge.textContent = '○ بدون GPS';
        }
        applyServerGeoButtonState();
    });
}

async function locateNow(){
    const btn = document.getElementById('btn-locate-now');
    btn.disabled = true;
    const old = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-circle-notch fa-spin"></i> جارٍ تحديد موقعي...';
    try {
        const pos = await resolvePosition();
        userLat = pos.coords.latitude;
        userLng = pos.coords.longitude;
        userAccuracy = Number.isFinite(pos.coords.accuracy) ? Math.round(pos.coords.accuracy) : null;
        locationCapturedAt = new Date().toISOString();
        hasManualLocate = true;
        updateMap(cachedLocs, userLat, userLng, true);
        setLocBadge(true, `تم تحديد موقعك الآن${userAccuracy ? ` بدقة ±${userAccuracy}م` : ''}`);
        await checkLocation();
        showToast(`تم تحديث موقعك الآن${userAccuracy ? ` بدقة ±${userAccuracy}م` : ''}`, true);
    } catch (e) {
        hasManualLocate = false;
        showToast(geolocationErrorMessage(e), false);
    } finally {
        btn.disabled = false;
        btn.innerHTML = old;
        applyServerGeoButtonState();
    }
}

function setLocBadge(ok, text){
    document.getElementById('loc-text').textContent = text;
    const badge = document.getElementById('loc-badge');
    badge.className = `loc-badge ${ok ? 'allowed' : 'denied'}`;
    badge.textContent = ok ? '✓ مسموح' : '✗ خارج النطاق';
}

function setLocBadgeNeutral(text){
    document.getElementById('loc-text').textContent = text;
    const badge = document.getElementById('loc-badge');
    badge.className = 'loc-badge neutral';
    badge.textContent = '○ معلومات';
}

applyServerGeoButtonState();
checkLocation();
setInterval(checkLocation, 60000);
window.addEventListener('resize', invalidateMapSize);

async function doCheckIn(){
    if(SERVER_ENFORCE_GEO && !hasManualLocate){ showToast('قبل التسجيل اضغط زر «موقعي الآن»', false); return; }
    if(SERVER_ENFORCE_GEO && userLat === null){ showToast('يلزم السماح بتحديد الموقع من المتصفح', false); return; }

    const btn = document.getElementById('btn-checkin');
    setLoading(btn, true);

    try{
        const res  = await fetch('{{ route("portal.checkin") }}', {
            method:'POST',
            credentials:'same-origin',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
            body: JSON.stringify({ latitude: userLat, longitude: userLng, accuracy: userAccuracy, captured_at: locationCapturedAt })
        });
        let data;
        try {
            data = await res.json();
        } catch(parseErr) {
            showToast(res.status === 419 ? 'انتهت الجلسة، أعد تحميل الصفحة' : 'استجابة غير صالحة من الخادم', false);
            setLoading(btn, false);
            return;
        }
        if(data.success){
            document.getElementById('ci-time').textContent = data.time;
            portalCheckedIn = true;
            applyServerGeoButtonState();
            showToast(data.message, true);
        } else {
            showToast(data.message || 'تعذّر التسجيل', false);
        }
    } catch(e){ showToast('حدث خطأ في الاتصال', false); }
    setLoading(btn, false);
}

async function doCheckOut(){
    if(SERVER_ENFORCE_GEO && !hasManualLocate){ showToast('قبل التسجيل اضغط زر «موقعي الآن»', false); return; }
    if(SERVER_ENFORCE_GEO && userLat === null){ showToast('يلزم السماح بتحديد الموقع من المتصفح', false); return; }

    const btn = document.getElementById('btn-checkout');
    setLoading(btn, true);

    try{
        const res  = await fetch('{{ route("portal.checkout") }}', {
            method:'POST',
            credentials:'same-origin',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
            body: JSON.stringify({ latitude: userLat, longitude: userLng, accuracy: userAccuracy, captured_at: locationCapturedAt })
        });
        let data;
        try {
            data = await res.json();
        } catch(parseErr) {
            showToast(res.status === 419 ? 'انتهت الجلسة، أعد تحميل الصفحة' : 'استجابة غير صالحة من الخادم', false);
            setLoading(btn, false);
            return;
        }
        if(data.success){
            document.getElementById('co-time').textContent = data.time;
            portalCheckedOut = true;
            applyServerGeoButtonState();
            showToast(`${data.message} (${data.hours} ساعة)`, true);
        } else {
            showToast(data.message || 'تعذّر التسجيل', false);
        }
    } catch(e){ showToast('حدث خطأ في الاتصال', false); }
    setLoading(btn, false);
}

async function submitRequest(){
    const type   = document.getElementById('req-type').value;
    const date   = document.getElementById('req-date').value;
    const from   = document.getElementById('req-from').value;
    const to     = document.getElementById('req-to').value;
    const reason = document.getElementById('req-reason').value.trim();

    if(!reason || reason.length < 10){
        showToast('يرجى كتابة سبب واضح (10 أحرف على الأقل)', false); return;
    }

    const btn = document.getElementById('btn-send-req');
    setLoading(btn, true);

    try{
        const res  = await fetch('{{ route("portal.request") }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
            body: JSON.stringify({type, date, from_time:from||null, to_time:to||null, reason})
        });
        const data = await res.json();
        if(data.success){
            showToast(data.message, true);
            document.getElementById('req-reason').value = '';
            document.getElementById('req-from').value   = '';
            document.getElementById('req-to').value     = '';
        } else {
            showToast(data.message || 'حدث خطأ', false);
        }
    } catch(e){ showToast('حدث خطأ، حاول مجدداً', false); }
    setLoading(btn, false);
}

function switchTab(name, el){
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');
}

function toggleTimeFields(){
    const type  = document.getElementById('req-type').value;
    const show  = ['permission','late'].includes(type);
    document.getElementById('time-fields').style.display = show ? 'grid' : 'none';
}
toggleTimeFields();

let toastTimer;
let lastZoneState = null;
function showToast(msg, ok){
    const t = document.getElementById('toast');
    document.getElementById('t-msg').textContent  = msg;
    document.getElementById('t-icon').className   = 't-icon fa ' + (ok ? 'fa-circle-check' : 'fa-circle-xmark');
    t.className = 'show ' + (ok ? 'success' : 'error');
    t.style.color = ok ? 'var(--green)' : 'var(--red)';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { t.classList.remove('show'); }, 3500);
}

function notifyZoneState(isInside){
    if(lastZoneState === isInside) return;
    lastZoneState = isInside;
    if(isInside){
        showToast('أنت داخل نطاق الشركة ويمكنك التسجيل', true);
    } else {
        showToast('تنبيه: أنت خارج نطاق الشركة، وسيتم تسجيل الحالة كخارج النطاق', false);
    }
}

function setLoading(btn, on){
    btn.classList.toggle('loading', on);
    btn.disabled = on;
}
</script>
</body>
</html>

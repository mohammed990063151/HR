<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الطلبات</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body{margin:0;background:#f7f8fb;color:#1f2937;font-family:'Cairo',sans-serif}
.wrap{max-width:980px;margin:0 auto;padding:14px}
.head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.title{font-weight:700;font-size:1.2rem}
.card{background:#fff;border:1px solid #e7ebf1;border-radius:14px;padding:14px;margin-bottom:12px}
.row{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
.field,.btn{border:1px solid #d8deea;border-radius:10px;padding:9px 10px;font-family:inherit;background:#fff}
.btn{cursor:pointer;background:#121826;color:#fff}
.list .item{border:1px solid #edf1f6;border-radius:10px;padding:10px;margin-bottom:8px}
.meta{color:#6b7280;font-size:.85rem}
.badge{display:inline-block;padding:3px 10px;border-radius:999px;font-size:.75rem}
.pending{background:#fff7ed;color:#9a3412}.approved{background:#ecfdf5;color:#065f46}.rejected{background:#fef2f2;color:#991b1b}
.two{display:grid;grid-template-columns:1fr 1fr;gap:8px}
@media(max-width:768px){.row{grid-template-columns:1fr 1fr}.two{grid-template-columns:1fr}.wrap{padding:10px}}
</style>
</head>
<body>
<div class="wrap">
    <div class="head">
        <div class="title">الطلبات</div>
        <a href="{{ route('portal.index') }}" class="meta">الرجوع للبوابة</a>
    </div>

    <div class="card">
        <form class="row" method="GET" action="{{ route('portal.requests') }}">
            <select class="field" name="status">
                <option value="">كل الحالات</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>في الانتظار</option>
                <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>مؤكد</option>
                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>مرفوض</option>
            </select>
            <select class="field" name="type">
                <option value="">كل الأنواع</option>
                @foreach($requestTypes as $t)
                    <option value="{{ $t->code }}" {{ $type === $t->code ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
            <select class="field" name="sort">
                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>الأحدث أولاً</option>
                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
            </select>
            <button class="btn" type="submit">تصفية</button>
        </form>
    </div>

    <div class="card">
        <div style="font-weight:700;margin-bottom:8px">طلب جديد</div>
        <div class="two">
            <select class="field" id="req-type">
                @foreach($requestTypes as $t)
                    <option value="{{ $t->code }}" data-requires-time="{{ $t->requires_time ? '1' : '0' }}">{{ $t->name }}</option>
                @endforeach
            </select>
            <input type="date" class="field" id="req-date" min="{{ today()->format('Y-m-d') }}" value="{{ today()->format('Y-m-d') }}">
        </div>
        <div class="two" id="time-row" style="margin-top:8px;">
            <input type="time" class="field" id="req-from" placeholder="من">
            <input type="time" class="field" id="req-to" placeholder="إلى">
        </div>
        <textarea id="req-reason" class="field" rows="3" style="width:100%;margin-top:8px;" placeholder="سبب الطلب..."></textarea>
        <button class="btn" style="margin-top:8px;width:100%;" onclick="submitEmployeeRequest()">إرسال الطلب</button>
    </div>

    <div class="card list">
        @forelse($requests as $req)
            <div class="item">
                <div style="display:flex;justify-content:space-between;gap:10px;align-items:center;">
                    <div style="font-weight:700">{{ $req->typeLabel() }}</div>
                    <span class="badge {{ $req->status }}">{{ $req->statusLabel() }}</span>
                </div>
                <div class="meta">التاريخ: {{ optional($req->date)->format('Y-m-d') }} @if($req->from_time && $req->to_time) • {{ $req->from_time }} - {{ $req->to_time }} @endif</div>
                <div class="meta">{{ $req->waitingAtLabel() }}</div>
                <div style="margin-top:6px;">{{ $req->reason }}</div>
            </div>
        @empty
            <div class="meta">لا توجد طلبات.</div>
        @endforelse
        <div style="margin-top:10px;">{{ $requests->links() }}</div>
    </div>
</div>
<script>
function toggleTimeFields(){
    const selected = document.getElementById('req-type').selectedOptions[0];
    const needTime = selected?.dataset?.requiresTime === '1';
    document.getElementById('time-row').style.display = needTime ? 'grid' : 'none';
}
document.getElementById('req-type')?.addEventListener('change', toggleTimeFields);
toggleTimeFields();

async function submitEmployeeRequest(){
    const type = document.getElementById('req-type').value;
    const date = document.getElementById('req-date').value;
    const from = document.getElementById('req-from').value || null;
    const to = document.getElementById('req-to').value || null;
    const reason = document.getElementById('req-reason').value.trim();
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if(!type || !date || reason.length < 10){ alert('أدخل البيانات المطلوبة (سبب لا يقل عن 10 أحرف).'); return; }
    const res = await fetch("{{ route('portal.request') }}", {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
        body: JSON.stringify({type, date, from_time:from, to_time:to, reason})
    });
    const data = await res.json();
    if(!res.ok || !data.success){ alert(data.message || 'تعذر إرسال الطلب'); return; }
    window.location.reload();
}
</script>
</body>
</html>

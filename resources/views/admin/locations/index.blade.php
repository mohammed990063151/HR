@extends('layouts.master')

@section('style')
<style>
/* متوافق مع لوحة التحكم (dashboard) */
.admin-locations-page {
    --al-primary: #4f46e5;
    --al-primary-pale: rgba(79, 70, 229, 0.1);
    --al-text: #1e293b;
    --al-muted: #64748b;
    --al-border: rgba(15, 23, 42, 0.08);
    --al-card: #ffffff;
    --al-page-bg: #f8fafc;
    --al-radius: 14px;
    --al-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
}

.admin-locations-page.page-wrapper {
    background: var(--al-page-bg);
    min-height: calc(100vh - 72px);
    padding: 96px clamp(16px, 2.5vw, 32px) 48px;
}
@media (max-width: 768px) {
    .admin-locations-page.page-wrapper {
        padding-top: 84px;
        padding-left: 12px;
        padding-right: 12px;
    }
}

/* يملأ عرض المنطقة المتاحة مثل /home */
.admin-locations-page .content.container-fluid {
    width: 100%;
    max-width: min(1680px, 100%);
    margin-left: auto;
    margin-right: auto;
    padding-left: 0;
    padding-right: 0;
}

/* رأس الصفحة — نفس أسلوب hr-header */
.admin-locations-page .al-page-head {
    margin-bottom: 28px;
}
.admin-locations-page .al-title-row {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
}
.admin-locations-page .al-title-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: var(--al-primary-pale);
    color: var(--al-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
    box-shadow: var(--al-shadow);
    border: 1px solid var(--al-border);
}
.admin-locations-page .al-page-head h1 {
    font-size: 1.55rem;
    font-weight: 700;
    color: var(--al-text);
    margin: 0 0 6px;
    line-height: 1.25;
}
.admin-locations-page .al-page-head .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.88rem;
}
.admin-locations-page .al-page-head .breadcrumb-item + .breadcrumb-item::before {
    float: right;
    padding-left: 0.5rem;
    padding-right: 0;
    color: var(--al-muted);
}

/* بطاقات */
.admin-locations-page .al-card {
    background: var(--al-card);
    border-radius: var(--al-radius);
    border: 1px solid var(--al-border);
    box-shadow: var(--al-shadow);
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.admin-locations-page .al-card-head {
    padding: 16px 20px;
    border-bottom: 1px solid var(--al-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    background: linear-gradient(180deg, #fafbfc 0%, #fff 100%);
}
.admin-locations-page .al-card-head h2 {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--al-text);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.admin-locations-page .al-card-head h2 i {
    color: var(--al-primary);
    font-size: 1.1rem;
}
.admin-locations-page .al-card-body {
    padding: 20px;
}
.admin-locations-page .al-card-body.p-0 {
    padding: 0;
}

.admin-locations-page .form-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--al-muted);
    margin-bottom: 0.35rem;
    text-transform: none;
}
.admin-locations-page .form-control {
    border-radius: 10px;
    border-color: #e2e8f0;
}
.admin-locations-page .form-control:focus {
    border-color: var(--al-primary);
    box-shadow: 0 0 0 3px var(--al-primary-pale);
}
.admin-locations-page .btn-submit-loc {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.55rem 1.25rem;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none;
    box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
}
.admin-locations-page .btn-submit-loc:hover {
    filter: brightness(1.05);
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
    color: #fff;
}

/* جدول */
.admin-locations-page .table-responsive {
    border-radius: 0 0 var(--al-radius) var(--al-radius);
}
.admin-locations-page .table {
    margin-bottom: 0;
}
.admin-locations-page .table thead th {
    background: #f8fafc;
    font-weight: 700;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--al-muted);
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px;
    white-space: nowrap;
}
.admin-locations-page .table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-color: #f1f5f9;
    color: var(--al-text);
}
.admin-locations-page .table tbody tr:hover td {
    background: rgba(79, 70, 229, 0.03);
}
.admin-locations-page .table code {
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #0f172a;
}
.admin-locations-page .badge-status {
    font-size: 0.72rem;
    padding: 0.4em 0.75em;
    border-radius: 20px;
    font-weight: 600;
}

@media (max-width: 991px) {
    .admin-locations-page .btn-submit-loc {
        width: 100%;
    }
}
</style>
@endsection

@section('content')
<div class="page-wrapper admin-locations-page">
    <div class="content container-fluid">

        <header class="al-page-head">
            <div class="al-title-row">
                <div class="al-title-icon" aria-hidden="true">
                    <i class="la la-map-marked-alt"></i>
                </div>
                <div>
                    <h1>مواقع الحضور الجغرافية</h1>
                    <ul class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">المواقع الجغرافية</li>
                    </ul>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" style="border-radius:12px;" role="alert">
                <i class="fa fa-check-circle ml-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
            </div>
        @endif

        <section class="al-card" aria-labelledby="add-loc-heading">
            <div class="al-card-head">
                <h2 id="add-loc-heading"><i class="fa fa-plus-circle"></i> إضافة موقع جديد</h2>
            </div>
            <div class="al-card-body">
                <form method="post" action="{{ route('admin.locations.store') }}" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-lg-3 col-md-6">
                            <label class="form-label" for="loc-name">اسم الموقع</label>
                            <input id="loc-name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="مثال: المقر الرئيسي" required>
                            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label class="form-label" for="loc-lat">خط العرض</label>
                            <input id="loc-lat" class="form-control @error('latitude') is-invalid @enderror" name="latitude" type="text" inputmode="decimal" value="{{ old('latitude') }}" placeholder="24.7136" required>
                            @error('latitude')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label class="form-label" for="loc-lng">خط الطول</label>
                            <input id="loc-lng" class="form-control @error('longitude') is-invalid @enderror" name="longitude" type="text" inputmode="decimal" value="{{ old('longitude') }}" placeholder="46.6753" required>
                            @error('longitude')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label class="form-label" for="loc-r">نصف القطر (م)</label>
                            <input id="loc-r" class="form-control @error('radius_meters') is-invalid @enderror" name="radius_meters" type="number" min="1" step="1" value="{{ old('radius_meters', 100) }}" placeholder="100" required>
                            @error('radius_meters')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-lg-3 col-md-12 d-flex align-items-end">
                            <button class="btn btn-primary btn-submit-loc btn-block" type="submit">
                                <i class="fa fa-plus-circle"></i> إضافة الموقع
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="al-card mb-0" aria-labelledby="list-loc-heading">
            <div class="al-card-head">
                <h2 id="list-loc-heading"><i class="fa fa-list-ul"></i> قائمة المواقع</h2>
                <span class="badge badge-light text-dark border" style="font-size:0.8rem;font-weight:600;">{{ $locations->count() }} موقع</span>
            </div>
            <div class="al-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>إحداثيات</th>
                                <th>النطاق (م)</th>
                                <th>الحالة</th>
                                <th class="text-center" style="min-width: 140px;">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($locations as $loc)
                            <tr>
                                <td><strong>{{ $loc->name }}</strong></td>
                                <td><code>{{ $loc->latitude }}, {{ $loc->longitude }}</code></td>
                                <td>{{ $loc->radius_meters }}</td>
                                <td>
                                    @if($loc->is_active)
                                        <span class="badge badge-success badge-status">نشط</span>
                                    @else
                                        <span class="badge badge-secondary badge-status">موقوف</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form method="post" action="{{ route('admin.locations.toggle', $loc) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded" title="تبديل التفعيل">
                                            <i class="fa fa-power-off"></i>
                                        </button>
                                    </form>
                                    <form method="post" action="{{ route('admin.locations.destroy', $loc) }}" class="d-inline" onsubmit="return confirm('حذف هذا الموقع؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="حذف">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="fa fa-map-marker-alt fa-2x mb-2 d-block opacity-25"></i>
                                    لا توجد مواقع بعد. أضف موقعاً من النموذج أعلاه.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection

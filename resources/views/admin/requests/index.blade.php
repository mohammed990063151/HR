@extends('layouts.master')

@section('style')
<style>
.admin-requests-page {
    --ar-primary: #4f46e5;
    --ar-primary-pale: rgba(79, 70, 229, 0.1);
    --ar-text: #1e293b;
    --ar-muted: #64748b;
    --ar-border: rgba(15, 23, 42, 0.08);
    --ar-card: #ffffff;
    --ar-page-bg: #f8fafc;
    --ar-radius: 14px;
    --ar-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
}
.admin-requests-page.page-wrapper {
    background: var(--ar-page-bg);
    min-height: calc(100vh - 72px);
    padding: 96px clamp(16px, 2.5vw, 32px) 48px;
}
@media (max-width: 768px) {
    .admin-requests-page.page-wrapper { padding-top: 84px; }
}
.admin-requests-page .content.container-fluid {
    width: 100%;
    max-width: min(1680px, 100%);
    margin-left: auto;
    margin-right: auto;
    padding-left: 0;
    padding-right: 0;
}
.admin-requests-page .al-page-head { margin-bottom: 28px; }
.admin-requests-page .al-title-row {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
}
.admin-requests-page .al-title-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: var(--ar-primary-pale);
    color: var(--ar-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
    box-shadow: var(--ar-shadow);
    border: 1px solid var(--ar-border);
}
.admin-requests-page .al-page-head h1 {
    font-size: 1.55rem;
    font-weight: 700;
    color: var(--ar-text);
    margin: 0 0 6px;
}
.admin-requests-page .al-page-head .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.88rem;
}
.admin-requests-page .al-card {
    background: var(--ar-card);
    border-radius: var(--ar-radius);
    border: 1px solid var(--ar-border);
    box-shadow: var(--ar-shadow);
    overflow: hidden;
}
.admin-requests-page .table thead th {
    background: #f8fafc;
    font-weight: 700;
    font-size: 0.78rem;
    color: var(--ar-muted);
    padding: 12px 16px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
}
.admin-requests-page .table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-color: #f1f5f9;
}
.admin-requests-page .table tbody tr:hover td {
    background: rgba(79, 70, 229, 0.03);
}
</style>
@endsection

@section('content')
<div class="page-wrapper admin-requests-page">
    <div class="content container-fluid">

        <header class="al-page-head">
            <div class="al-title-row">
                <div class="al-title-icon" aria-hidden="true">
                    <i class="la la-inbox"></i>
                </div>
                <div>
                    <h1>طلبات الموظفين</h1>
                    <ul class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">طلبات الموظفين</li>
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

        <div class="al-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>النوع</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>متوقف عند</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td><strong>{{ $req->employee?->name }}</strong></td>
                            <td>{{ $req->typeLabel() }}</td>
                            <td>{{ $req->date->format('Y-m-d') }}</td>
                            <td>{{ $req->statusLabel() }}</td>
                            <td>{{ $req->waitingAtLabel() }}</td>
                            <td>
                                @if($req->status === 'pending')
                                <form method="post" action="{{ route('admin.requests.review', $req) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-sm btn-success rounded" type="submit">موافقة</button>
                                </form>
                                <form method="post" action="{{ route('admin.requests.review', $req) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="btn btn-sm btn-danger rounded" type="submit">رفض</button>
                                </form>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">لا توجد طلبات</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection

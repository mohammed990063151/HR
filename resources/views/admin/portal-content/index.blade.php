@extends('layouts.master')

@section('style')
<style>
@media (max-width: 767px){
    .portal-content-page .card-body{padding:12px;}
    .portal-content-page .btn{width:100%;}
    .portal-content-page table thead{display:none;}
    .portal-content-page table,
    .portal-content-page table tbody,
    .portal-content-page table tr,
    .portal-content-page table td{display:block;width:100%;}
    .portal-content-page table tr{
        border-bottom:1px solid #eef1f6;
        padding:10px 0;
    }
    .portal-content-page table td{
        border:0;
        padding:6px 12px;
    }
    .portal-content-page table td::before{
        content: attr(data-label);
        font-weight:700;
        display:block;
        color:#6b7280;
        margin-bottom:2px;
        font-size:.78rem;
    }
}
</style>
@endsection

@section('content')
<div class="page-wrapper portal-content-page">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">إعلانات ومناسبات الموظفين</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">إدارة المحتوى</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.portal-content.store') }}" class="row">
                    @csrf
                    <div class="col-md-3 mb-2">
                        <label>النوع</label>
                        <select name="type" class="form-control" required>
                            <option value="announcement">إعلان</option>
                            <option value="occasion">مناسبة أسبوعية</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>العنوان</label>
                        <input name="title" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>من تاريخ</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>إلى تاريخ</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-2 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">إضافة</button>
                    </div>
                    <div class="col-12 mt-2">
                        <label>المحتوى</label>
                        <textarea name="body" class="form-control" rows="3" placeholder="نص الإعلان/المناسبة"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>النوع</th>
                                <th>العنوان</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td data-label="النوع">{{ $item->type === 'announcement' ? 'إعلان' : 'مناسبة' }}</td>
                                <td data-label="العنوان">
                                    <strong>{{ $item->title }}</strong>
                                    @if($item->body)
                                        <div class="text-muted small mt-1">{{ \Illuminate\Support\Str::limit($item->body, 120) }}</div>
                                    @endif
                                </td>
                                <td data-label="التاريخ">{{ optional($item->start_date)->format('Y-m-d') ?: '-' }} → {{ optional($item->end_date)->format('Y-m-d') ?: '-' }}</td>
                                <td data-label="الحالة">
                                    <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $item->is_active ? 'نشط' : 'موقوف' }}
                                    </span>
                                </td>
                                <td data-label="إجراءات">
                                    <form method="POST" action="{{ route('admin.portal-content.toggle', $item) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-secondary">تبديل</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.portal-content.destroy', $item) }}" class="d-inline" onsubmit="return confirm('حذف هذا العنصر؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">لا توجد بيانات</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">{{ $items->links() }}</div>
    </div>
</div>
@endsection

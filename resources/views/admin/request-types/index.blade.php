@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header"><h3 class="page-title">أنواع الطلبات (ديناميكي)</h3></div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.request-types.store') }}" class="row">
                    @csrf
                    <div class="col-md-4 mb-2"><label>اسم النوع</label><input class="form-control" name="name" placeholder="طلب تصحيح" required></div>
                    <div class="col-md-3 mb-2"><label>الكود (اختياري)</label><input class="form-control" name="code" placeholder="correction_request"></div>
                    <div class="col-md-3 mb-2"><label>الترتيب</label><input type="number" min="0" class="form-control" name="sort_order" value="0"></div>
                    <div class="col-md-2 mb-2 d-flex align-items-end"><button class="btn btn-primary btn-block">إضافة</button></div>
                    <div class="col-12"><label><input type="checkbox" name="requires_time" value="1"> يحتاج وقت من/إلى</label></div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead><tr><th>الاسم</th><th>الكود</th><th>يحتاج وقت</th><th>الحالة</th><th>إجراء</th></tr></thead>
                        <tbody>
                        @forelse($types as $type)
                            <tr>
                                <td>{{ $type->name }}</td>
                                <td><code>{{ $type->code }}</code></td>
                                <td>{{ $type->requires_time ? 'نعم' : 'لا' }}</td>
                                <td><span class="badge {{ $type->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $type->is_active ? 'نشط' : 'موقوف' }}</span></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.request-types.toggle', $type) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-secondary">تبديل</button></form>
                                    <form method="POST" action="{{ route('admin.request-types.destroy', $type) }}" class="d-inline" onsubmit="return confirm('حذف النوع؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">حذف</button></form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">لا توجد أنواع طلبات</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

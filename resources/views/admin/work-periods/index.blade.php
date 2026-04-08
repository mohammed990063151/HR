@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">فترات العمل (صباحي / مسائي)</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.work-periods.store') }}" class="row">
                    @csrf
                    <div class="col-md-3 mb-2">
                        <label>اسم الفترة</label>
                        <input name="title" class="form-control" placeholder="مثال: الفترة الصباحية" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>من</label>
                        <input type="time" name="from_time" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>إلى</label>
                        <input type="time" name="to_time" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>النوع</label>
                        <select name="type" class="form-control">
                            <option value="morning">صباحية</option>
                            <option value="evening">مسائية</option>
                            <option value="custom">مخصص</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-2">
                        <label>ترتيب</label>
                        <input type="number" min="0" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-md-2 mb-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-block">إضافة فترة</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">تخصيص الفترات لكل موظف</h5>
                <form method="POST" action="{{ route('admin.work-periods.assign') }}" class="row">
                    @csrf
                    <div class="col-md-4 mb-2">
                        <label>الموظف</label>
                        <select name="employee_id" class="form-control" required>
                            <option value="">اختر الموظف</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>فترات العمل</label>
                        <select name="work_period_ids[]" class="form-control" multiple size="4" required>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->title }} ({{ \Carbon\Carbon::createFromFormat('H:i:s', $period->from_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $period->to_time)->format('h:i A') }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">اضغط Ctrl لاختيار أكثر من فترة.</small>
                    </div>
                    <div class="col-md-2 mb-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-block">حفظ التخصيص</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead><tr><th>الاسم</th><th>الوقت</th><th>النوع</th><th>الموظفون المربوطون</th><th>الحالة</th><th>إجراء</th></tr></thead>
                        <tbody>
                        @forelse($periods as $p)
                            <tr>
                                <td>{{ $p->title }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $p->from_time)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $p->to_time)->format('h:i A') }}</td>
                                <td>{{ $p->type }}</td>
                                <td>
                                    @if($p->employees->isEmpty())
                                        <span class="text-muted">عام للجميع</span>
                                    @else
                                        {{ $p->employees->pluck('name')->take(3)->implode('، ') }}
                                        @if($p->employees->count() > 3)
                                            <span class="text-muted">... +{{ $p->employees->count() - 3 }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td><span class="badge {{ $p->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $p->is_active ? 'نشط' : 'موقوف' }}</span></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.work-periods.toggle', $p) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-secondary">تبديل</button></form>
                                    <form method="POST" action="{{ route('admin.work-periods.destroy', $p) }}" class="d-inline" onsubmit="return confirm('حذف الفترة؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">حذف</button></form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">لا توجد فترات عمل</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

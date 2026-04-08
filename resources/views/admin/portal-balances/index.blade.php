@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">رصيد بوابة الموظف</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">إدارة الرصيد الشهري</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.portal-balances.store') }}" class="row">
                    @csrf
                    <div class="col-md-3 mb-2">
                        <label>الموظف</label>
                        <select name="employee_id" class="form-control" required>
                            <option value="">اختر الموظف</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>الشهر</label>
                        <input type="number" min="1" max="12" name="month" class="form-control" value="{{ now()->month }}" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>السنة</label>
                        <input type="number" min="2000" max="2100" name="year" class="form-control" value="{{ now()->year }}" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>الرصيد المستحق</label>
                        <input type="number" min="0" name="deserved_balance" class="form-control" value="0" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>الرصيد المتبقي</label>
                        <input type="number" min="0" name="remaining_balance" class="form-control" value="0" required>
                    </div>
                    <div class="col-md-1 mb-2">
                        <label>غير مكتمل</label>
                        <input type="number" min="0" name="incomplete_records" class="form-control" value="0" required>
                    </div>
                    <div class="col-12 mt-2">
                        <label>ملاحظات</label>
                        <textarea name="notes" rows="2" class="form-control" placeholder="ملاحظة (اختياري)"></textarea>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-primary">حفظ / تحديث</button>
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
                            <th>الموظف</th>
                            <th>الشهر/السنة</th>
                            <th>المستحق</th>
                            <th>المتبقي</th>
                            <th>غير مكتمل</th>
                            <th>إجراء</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($balances as $balance)
                            <tr>
                                <td>{{ $balance->employee?->name ?? '-' }}</td>
                                <td>{{ $balance->month }}/{{ $balance->year }}</td>
                                <td>{{ $balance->deserved_balance }}</td>
                                <td>{{ $balance->remaining_balance }}</td>
                                <td>{{ $balance->incomplete_records }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.portal-balances.destroy', $balance) }}" onsubmit="return confirm('حذف السجل؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">لا توجد أرصدة بعد</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">{{ $balances->links() }}</div>
    </div>
</div>
@endsection

@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">حضور الموظفين</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">كل سجلات الحضور</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label class="mb-1 d-block">الموظف</label>
                        <select name="employee_id" class="form-control">
                            <option value="">كل الموظفين</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ (int) $employeeId === (int) $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} ({{ $emp->employee_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="mb-1 d-block">من تاريخ</label>
                        <input type="date" name="from" class="form-control" value="{{ $from }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="mb-1 d-block">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control" value="{{ $to }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary btn-block">تصفية</button>
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
                                <th>التاريخ</th>
                                <th>وقت الدخول</th>
                                <th>وقت الخروج</th>
                                <th>عدد الساعات</th>
                                <th>الحالة</th>
                                <th>حالة النطاق</th>
                                <th>تفاصيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $row)
                                <tr>
                                    <td>{{ $row->employee?->name ?? '-' }}</td>
                                    <td>{{ optional($row->date)->format('Y-m-d') }}</td>
                                    <td>{{ $row->check_in ? $row->check_in->format('h:i A') : '-' }}</td>
                                    <td>{{ $row->check_out ? $row->check_out->format('h:i A') : '-' }}</td>
                                    <td>{{ $row->working_hours !== null ? $row->working_hours : '-' }}</td>
                                    <td>{{ $row->status ?? '-' }}</td>
                                    <td>
                                        @if(str_contains((string) $row->notes, 'خارج النطاق'))
                                            <span class="badge badge-danger">خارج النطاق</span>
                                        @elseif(str_contains((string) $row->notes, 'داخل النطاق'))
                                            <span class="badge badge-success">داخل النطاق</span>
                                        @else
                                            <span class="badge badge-secondary">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->employee)
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attendance.show', $row->employee) }}">عرض</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">لا توجد بيانات حضور مطابقة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection

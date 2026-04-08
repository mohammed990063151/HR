@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">سجل حضور: {{ $employee->name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}">حضور الموظفين</a></li>
                        <li class="breadcrumb-item active">تفاصيل الموظف</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="form-inline">
                    <label class="mr-2">الشهر</label>
                    <select name="month" class="form-control mr-3">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endfor
                    </select>

                    <label class="mr-2">السنة</label>
                    <select name="year" class="form-control mr-3">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>

                    <button type="submit" class="btn btn-primary">عرض</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>الدخول</th>
                                <th>الخروج</th>
                                <th>المدة</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $row)
                                <tr>
                                    <td>{{ optional($row->date)->format('Y-m-d') }}</td>
                                    <td>{{ $row->check_in ? $row->check_in->format('h:i A') : '-' }}</td>
                                    <td>{{ $row->check_out ? $row->check_out->format('h:i A') : '-' }}</td>
                                    <td>{{ $row->working_hours !== null ? $row->working_hours . ' ساعة' : '-' }}</td>
                                    <td>{{ $row->status ?? '-' }}</td>
                                    <td>{{ $row->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">لا توجد سجلات في الفترة المحددة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection

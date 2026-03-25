@extends('layouts.master')
@section('content')
  
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">الحضور</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الحضور</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <!-- Search Filter -->
            <form method="GET" class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input name="name" value="{{ request('name') }}" type="text" class="form-control floating">
                        <label class="focus-label">اسم الموظف</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select name="month" class="select floating">
                            @for($m=1;$m<=12;$m++)
                                <option value="{{ $m }}" @selected((int)request('month', $month)==$m)>
                                    {{ $m }}
                                </option>
                            @endfor
                        </select>
                        <label class="focus-label">اختار الشهر</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select name="year" class="select floating">
                            @for($y=date('Y');$y>=date('Y')-10;$y--)
                                <option value="{{ $y }}" @selected((int)request('year', $year)==$y)>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                        <label class="focus-label">اختار السنة</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <button class="btn btn-success btn-block">بحث</button>
                </div>
            </form>
            <!-- /Search Filter -->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>اسم الموظف</th>
                                    @foreach($days as $d)
                                        <th>{{ $d }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $emp)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-xs" href="javascript:void(0);">
                                                    <img alt="" src="{{ URL::to('assets/img/profiles/avatar-09.jpg') }}">
                                                </a>
                                                <a href="javascript:void(0);">{{ $emp->name }}</a>
                                                <div class="text-muted" style="font-size:12px;">ID جهاز: {{ $emp->employee_id }}</div>
                                            </h2>
                                        </td>

                                        @foreach($days as $d)
                                        <td class="text-center">
                                            @php
                                                $present = !empty($attendanceMap[$emp->id][$d]);
                                                $selectedDate = \Carbon\Carbon::create($year, $month, $d)->format('Y-m-d');
                                            @endphp

                                            @if($present)
                                                <a href="javascript:void(0);"
                                                   class="open-attendance-modal"
                                                   data-employee-id="{{ $emp->id }}"
                                                   data-date="{{ $selectedDate }}"
                                                   data-toggle="modal"
                                                   data-target="#attendance_info">
                                                    <i class="fa fa-check text-success"></i>
                                                </a>
                                            @else
                                                <i class="fa fa-close text-danger"></i>
                                            @endif
                                        </td>
                                        @endforeach

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ 1 + count($days) }}" class="text-center">لا يوجد موظفين</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        
        <!-- Attendance Modal -->
        <div class="modal custom-modal fade" id="attendance_info" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">معلومات الحضور</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <strong id="modalEmployeeName">-</strong>
                            <span class="text-muted"> (ID: <span id="modalEmployeeId">-</span>)</span>
                            <div class="text-muted">التاريخ: <span id="modalDate">-</span></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card punch-status">
                                    <div class="card-body">
                                        <h5 class="card-title">الجدول الزمني</h5>

                                        <div class="punch-det">
                                            <h6>الدخول في</h6>
                                            <p id="modalCheckIn">-</p>
                                        </div>

                                        <div class="punch-info">
                                            <div class="punch-hours">
                                                <span id="modalWorkHours">-</span>
                                            </div>
                                        </div>

                                        <div class="punch-det">
                                            <h6>الخروج في</h6>
                                            <p id="modalCheckOut">-</p>
                                        </div>

                                        <div class="statistics">
                                            <div class="row">
                                                <div class="col-md-6 col-6 text-center">
                                                    <div class="stats-box">
                                                        <p>استراحة</p>
                                                        <h6>-</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-6 text-center">
                                                    <div class="stats-box">
                                                        <p>العمل الإضافي</p>
                                                        <h6>-</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card recent-activity">
                                    <div class="card-body">
                                        <h5 class="card-title">النشاط (كل البصمات)</h5>
                                        <ul class="res-activity-list" id="modalLogs">
                                            <li class="text-muted">-</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Attendance Modal -->
        
    </div>
    <!-- Page Wrapper -->

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    $(document).on('click', '.open-attendance-modal', function () {
        const employeeId = $(this).data('employee-id');
        const date = $(this).data('date');

        $('#modalEmployeeName').text('...');
        $('#modalEmployeeId').text(employeeId || '-');
        $('#modalDate').text(date || '-');
        $('#modalCheckIn').text('...');
        $('#modalCheckOut').text('...');
        $('#modalWorkHours').text('...');
        $('#modalLogs').html('<li class="text-muted">جاري التحميل...</li>');

        $.ajax({
            url: "{{ route('employees.attendance.modal') }}",
            method: "GET",
            data: { employee_id: employeeId, date: date },
            success: function (res) {
                $('#modalEmployeeName').text(res.employee?.name ?? '-');
                $('#modalEmployeeId').text(res.employee?.employee_id ?? employeeId ?? '-');
                $('#modalDate').text(res.date ?? date ?? '-');

                $('#modalCheckIn').text(res.check_in ?? '-');
                $('#modalCheckOut').text(res.check_out ?? '-');
                $('#modalWorkHours').text(res.work_hours ? (res.work_hours) : '-');

                if (res.logs && res.logs.length) {
                    let html = '';
                    res.logs.forEach(function (l) {
                        html += `
                          <li>
                            <p class="mb-0">بصمة</p>
                            <p class="res-activity-time">
                              <i class="fa fa-clock-o"></i> ${l.time}
                            </p>
                          </li>`;
                    });
                    $('#modalLogs').html(html);
                } else {
                    $('#modalLogs').html('<li class="text-muted">لا توجد بصمات لهذا اليوم</li>');
                }
            },
            error: function () {
                $('#modalLogs').html('<li class="text-danger">فشل تحميل البيانات</li>');
                $('#modalCheckIn').text('-');
                $('#modalCheckOut').text('-');
                $('#modalWorkHours').text('-');
            }
        });
    });

});
</script>
@endsection



{{-- 
@extends('layouts.master')
@section('content')
  
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">الحضور</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الحضور</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <!-- Search Filter -->
           <form method="GET" class="row filter-row">
    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus">
            <input name="name" value="{{ request('name') }}" type="text" class="form-control floating">
            <label class="focus-label">اسم الموظف</label>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus select-focus">
            <select name="month" class="select floating">
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" @selected((int)request('month', $month)==$m)>
                        {{ $m }}
                    </option>
                @endfor
            </select>
            <label class="focus-label">اختار الشهر</label>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus select-focus">
            <select name="year" class="select floating">
                @for($y=date('Y');$y>=date('Y')-10;$y--)
                    <option value="{{ $y }}" @selected((int)request('year', $year)==$y)>
                        {{ $y }}
                    </option>
                @endfor
            </select>
            <label class="focus-label">اختار السنة</label>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <button class="btn btn-success btn-block">بحث</button>
    </div>
</form>
            <!-- /Search Filter -->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                           <thead>
<tr>
    <th>اسم الموظف</th>
    @foreach($days as $d)
        <th>{{ $d }}</th>
    @endforeach
</tr>
</thead>
                            <tbody>
@forelse($employees as $emp)
    <tr>
        <td>
            <h2 class="table-avatar">
                <a class="avatar avatar-xs" href="javascript:void(0);">
                    <img alt="" src="{{ URL::to('assets/img/profiles/avatar-09.jpg') }}">
                </a>
                <a href="javascript:void(0);">{{ $emp->name }}</a>
                <div class="text-muted" style="font-size:12px;">ID جهاز: {{ $emp->employee_id }}</div>
            </h2>
        </td>

       @endforeach

    </tr>
@empty
    <tr>
        <td colspan="{{ 1 + count($days) }}" class="text-center">لا يوجد موظفين</td>
    </tr>
@endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        
        <!-- Attendance Modal -->
       <div class="modal custom-modal fade" id="attendance_info" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">معلومات الحضور</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <strong id="modalEmployeeName">-</strong>
                    <span class="text-muted"> (ID: <span id="modalEmployeeId">-</span>)</span>
                    <div class="text-muted">التاريخ: <span id="modalDate">-</span></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card punch-status">
                            <div class="card-body">
                                <h5 class="card-title">الجدول الزمني</h5>

                                <div class="punch-det">
                                    <h6>الدخول في</h6>
                                    <p id="modalCheckIn">-</p>
                                </div>

                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span id="modalWorkHours">-</span>
                                    </div>
                                </div>

                                <div class="punch-det">
                                    <h6>الخروج في</h6>
                                    <p id="modalCheckOut">-</p>
                                </div>

                                <div class="statistics">
                                    <div class="row">
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>استراحة</p>
                                                <h6>-</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>العمل الإضافي</p>
                                                <h6>-</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card recent-activity">
                            <div class="card-body">
                                <h5 class="card-title">النشاط (كل البصمات)</h5>
                                <ul class="res-activity-list" id="modalLogs">
                                    <li class="text-muted">-</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
        <!-- /Attendance Modal -->
        
    </div>
    <!-- Page Wrapper -->

    @section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    $(document).on('click', '.open-attendance-modal', function () {
        const employeeId = $(this).data('employee-id');
        const date = $(this).data('date');

        // Reset
        $('#modalEmployeeName').text('...');
        $('#modalEmployeeId').text(employeeId || '-');
        $('#modalDate').text(date || '-');
        $('#modalCheckIn').text('...');
        $('#modalCheckOut').text('...');
        $('#modalWorkHours').text('...');
        $('#modalLogs').html('<li class="text-muted">جاري التحميل...</li>');

        $.ajax({
            url: "{{ route('employees.attendance.modal') }}",
            method: "GET",
            data: { employee_id: employeeId, date: date },
            success: function (res) {
                $('#modalEmployeeName').text(res.employee?.name ?? '-');
                $('#modalEmployeeId').text(res.employee?.employee_id ?? employeeId ?? '-');
                $('#modalDate').text(res.date ?? date ?? '-');

                $('#modalCheckIn').text(res.check_in ? res.check_in : '-');
                $('#modalCheckOut').text(res.check_out ? res.check_out : '-');
                $('#modalWorkHours').text(res.work_hours ? (res.work_hours + ' hrs') : '-');

                if (res.logs && res.logs.length) {
                    let html = '';
                    res.logs.forEach(function (l) {
                        html += `
                          <li>
                            <p class="mb-0">بصمة</p>
                            <p class="res-activity-time">
                              <i class="fa fa-clock-o"></i> ${l.time}
                            </p>
                          </li>`;
                    });
                    $('#modalLogs').html(html);
                } else {
                    $('#modalLogs').html('<li class="text-muted">لا توجد بصمات لهذا اليوم</li>');
                }
            },
            error: function () {
                $('#modalLogs').html('<li class="text-danger">فشل تحميل البيانات</li>');
                $('#modalCheckIn').text('-');
                $('#modalCheckOut').text('-');
                $('#modalWorkHours').text('-');
            }
        });
    });

});
</script>
@endsection --}}

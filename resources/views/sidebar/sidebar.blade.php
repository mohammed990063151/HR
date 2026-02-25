<!-- Sidebar -->
{{-- @php
  $dashOpen = set_active(['home','em/dashboard']);
  $usersOpen = set_active(['search/user/list','userManagement','activity/log','activity/login/logout']);
  $empOpen = set_active([
      'all/employee/list','all/employee/card','form/holidays/new','form/leaves/new','form/leaves/employee/new',
      'form/leavesettings/page','attendance/page','attendance/employee/page','form/departments/page',
      'form/designations/page','form/timesheet/page','form/shiftscheduling/page','form/overtime/page'
  ]);
  $salesOpen = set_active(['create/estimate/page','form/estimates/page','payments','expenses/page']);
  $payrollOpen = set_active(['form/salary/page','form/payroll/items']);
  $reportsOpen = set_active(['form/expense/reports/page','form/invoice/reports/page','form/attendance/reports/page']);
@endphp

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title"><span>الرئيسية</span></li>

                {{-- Dashboard --}
                <li class="{{ $dashOpen }} submenu">
                    <a href="#dashMenu" data-toggle="collapse" aria-expanded="{{ $dashOpen ? 'true' : 'false' }}"
                       class="{{ $dashOpen ? '' : 'collapsed' }} {{ $dashOpen ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span>لوحة التحكم</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul id="dashMenu" class="collapse {{ $dashOpen ? 'show' : '' }}">
                        <li><a class="{{ set_active(['home']) }}" href="{{ route('home') }}">لوحة تحكم المدير</a></li>
                        <li><a class="{{ set_active(['em/dashboard']) }}" href="{{ route('em/dashboard') }}">لوحة تحكم الموظف</a></li>
                    </ul>
                </li>

                @if (Auth::user()->role_name=='Admin')
                    <li class="menu-title"><span>إدارة المستخدمين</span></li>

                    <li class="{{ $usersOpen }} submenu">
                        <a href="#usersMenu" data-toggle="collapse" aria-expanded="{{ $usersOpen ? 'true' : 'false' }}"
                           class="{{ $usersOpen ? '' : 'collapsed' }} {{ $usersOpen ? 'noti-dot' : '' }}">
                            <i class="la la-user-secret"></i>
                            <span>إدارة المستخدمين</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul id="usersMenu" class="collapse {{ $usersOpen ? 'show' : '' }}">
                            <li><a class="{{ set_active(['search/user/list','userManagement']) }}" href="{{ route('userManagement') }}">جميع المستخدمين</a></li>
                        </ul>
                    </li>
                @endif

                <li class="menu-title"><span>الموظفون</span></li>

                <li class="{{ $empOpen }} submenu">
                    <a href="#empMenu" data-toggle="collapse" aria-expanded="{{ $empOpen ? 'true' : 'false' }}"
                       class="{{ $empOpen ? '' : 'collapsed' }} {{ $empOpen ? 'noti-dot' : '' }}">
                        <i class="la la-user"></i>
                        <span>الموظفون</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul id="empMenu" class="collapse {{ $empOpen ? 'show' : '' }}">
                        <li><a class="{{ set_active(['all/employee/card']) }}" href="{{ route('all/employee/card') }}">جميع الموظفين</a></li>
                        <li><a class="{{ set_active(['form/holidays/new']) }}" href="{{ route('form/holidays/new') }}">الإجازات الرسمية</a></li>
                        <li><a class="{{ set_active(['form/leaves/new']) }}" href="{{ route('form/leaves/new') }}">طلبات الإجازة (الإدارة)</a></li>
                        <li><a class="{{ set_active(['form/leaves/employee/new']) }}" href="{{ route('form/leaves/employee/new') }}">طلبات الإجازة (الموظف)</a></li>
                        <li><a class="{{ set_active(['form/leavesettings/page']) }}" href="{{ route('form/leavesettings/page') }}">إعدادات الإجازات</a></li>
                        <li><a class="{{ set_active(['attendance/page']) }}" href="{{ route('attendance/page') }}">الحضور والانصراف (الإدارة)</a></li>
                        <li><a class="{{ set_active(['attendance/employee/page']) }}" href="{{ route('attendance/employee/page') }}">الحضور والانصراف (الموظف)</a></li>
                        <li><a class="{{ set_active(['form/departments/page']) }}" href="{{ route('form/departments/page') }}">الأقسام</a></li>
                        <li><a class="{{ set_active(['form/designations/page']) }}" href="{{ route('form/designations/page') }}">المسميات الوظيفية</a></li>
                        <li><a class="{{ set_active(['form/timesheet/page']) }}" href="{{ route('form/timesheet/page') }}">سجل الدوام</a></li>
                        <li><a class="{{ set_active(['form/shiftscheduling/page']) }}" href="{{ route('form/shiftscheduling/page') }}">الجداول والمناوبات</a></li>
                        <li><a class="{{ set_active(['form/overtime/page']) }}" href="{{ route('form/overtime/page') }}">العمل الإضافي</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>الموارد البشرية</span></li>

                <li class="{{ $salesOpen }} submenu">
                         <a href="#empMenu" data-toggle="collapse" aria-expanded="{{ $salesOpen ? 'true' : 'false' }}"
                       class="{{ $salesOpen ? '' : 'collapsed' }} {{ $salesOpen ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span>المبيعات</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul id="salesMenu" class="collapse {{ $salesOpen ? 'show' : '' }}">
                        <li><a class="{{ set_active(['form/estimates/page']) }}" href="{{ route('form/estimates/page') }}">التقديرات</a></li>
                        <li><a class="{{ set_active(['payments']) }}" href="{{ route('payments') }}">المدفوعات</a></li>
                        <li><a class="{{ set_active(['expenses/page']) }}" href="{{ route('expenses/page') }}">المصروفات</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>الرواتب</span></li>

                <li class="{{ $payrollOpen }} submenu">
                    {{-- <a href="#payrollMenu" data-toggle="collapse" aria-expanded="{{ $payrollOpen ? 'true' : 'false' }}"
                       class="{{ $payrollOpen ? '' : 'collapsed' }} {{ $payrollOpen ? 'noti-dot' : '' }}"> --}
                         <a href="#empMenu" data-toggle="collapse" aria-expanded="{{ $payrollOpen ? 'true' : 'false' }}"
                       class="{{ $payrollOpen ? '' : 'collapsed' }} {{ $payrollOpen ? 'noti-dot' : '' }}">
                        <i class="la la-money"></i>
                        <span>الرواتب</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul id="payrollMenu" class="collapse {{ $payrollOpen ? 'show' : '' }}">
                        <li><a class="{{ set_active(['form/salary/page']) }}" href="{{ route('form/salary/page') }}">رواتب الموظفين</a></li>
                        <li><a href="#">قسائم الرواتب</a></li>
                        <li><a class="{{ set_active(['form/payroll/items']) }}" href="{{ route('form/payroll/items') }}">بنود الرواتب</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>التقارير</span></li>

                <li class="{{ $reportsOpen }} submenu">
                    <a href="#reportsMenu" data-toggle="collapse" aria-expanded="{{ $reportsOpen ? 'true' : 'false' }}"
                       class="{{ $reportsOpen ? '' : 'collapsed' }} {{ $reportsOpen ? 'noti-dot' : '' }}">
                        <i class="la la-pie-chart"></i>
                        <span>التقارير</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul id="reportsMenu" class="collapse {{ $reportsOpen ? 'show' : '' }}">
                        <li><a class="{{ set_active(['form/expense/reports/page']) }}" href="{{ route('form/expense/reports/page') }}">تقرير المصروفات</a></li>
                        <li><a class="{{ set_active(['form/invoice/reports/page']) }}" href="{{ route('form/invoice/reports/page') }}">تقرير الفواتير</a></li>
                        <li><a class="{{ set_active(['form/attendance/reports/page']) }}" href="{{ route('form/attendance/reports/page') }}">تقرير الحضور</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div> --}}
<!-- /Sidebar -->



<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>الرئيسية</span>
                </li>

                <li class="{{set_active(['home','em/dashboard'])}} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span>لوحة التحكم</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}">لوحة تحكم المدير</a></li>
                        <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}">لوحة تحكم الموظف</a></li>
                    </ul>
                </li>

                @if (Auth::user()->role_name=='Admin')
                    <li class="menu-title">
                        <span>الصلاحيات</span>
                    </li>

                    <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                        <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                            <i class="la la-user-secret"></i>
                            <span>إدارة المستخدمين</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">جميع المستخدمين</a></li>
                        </ul>
                    </li>
                @endif

                <li class="menu-title">
                    <span>الموظفون</span>
                </li>

                <li class="{{set_active([
                    'all/employee/list','all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leaves/employee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'
                ])}} submenu">
                    <a href="#" class="{{ set_active([
                        'all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                        'form/leaves/employee/new','form/leavesettings/page','attendance/page',
                        'attendance/employee/page','form/departments/page','form/designations/page',
                        'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'
                    ]) ? 'noti-dot' : '' }}">
                        <i class="la la-user"></i>
                        <span>الموظفون</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li>
                            <a class="{{set_active(['all/employee/list','all/employee/card'])}} {{ request()->is('all/employee/view/edit/*','employee/profile/*') ? 'active' : '' }}"
                               href="{{ route('all/employee/card') }}">
                                جميع الموظفين
                            </a>
                        </li>

                        <li><a class="{{set_active(['form/holidays/new'])}}" href="{{ route('form/holidays/new') }}">الإجازات</a></li>

                        <li>
                            <a class="{{set_active(['form/leaves/new'])}}" href="{{ route('form/leaves/new') }}">
                                طلبات الإجازة (الإدارة)
                                <span class="badge badge-pill bg-primary float-right">1</span>
                            </a>
                        </li>

                        <li><a class="{{set_active(['form/leaves/employee/new'])}}" href="{{route('form/leaves/employee/new')}}">طلبات الإجازة (الموظف)</a></li>
                        <li><a class="{{set_active(['form/leavesettings/page'])}}" href="{{ route('form/leavesettings/page') }}">إعدادات الإجازات</a></li>
                        <li><a class="{{set_active(['attendance/page'])}}" href="{{ route('attendance/page') }}">الحضور والانصراف (الإدارة)</a></li>
                        <li><a class="{{set_active(['attendance/employee/page'])}}" href="{{ route('attendance/employee/page') }}">الحضور والانصراف (الموظف)</a></li>
                        <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}">الأقسام</a></li>
                        <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}">المسميات الوظيفية</a></li>
                        <li><a class="{{set_active(['form/timesheet/page'])}}" href="{{ route('form/timesheet/page') }}">سجل الدوام</a></li>
                        <li><a class="{{set_active(['form/shiftscheduling/page'])}}" href="{{ route('form/shiftscheduling/page') }}">الجداول والمناوبات</a></li>
                        <li><a class="{{set_active(['form/overtime/page'])}}" href="{{ route('form/overtime/page') }}">العمل الإضافي</a></li>
                    </ul>
                </li>

                <li class="menu-title">
                    <span>الموارد البشرية</span>
                </li>

                <li class="{{set_active(['create/estimate/page','form/estimates/page','payments','expenses/page'])}} submenu">
                    <a href="#" class="{{ set_active(['create/estimate/page','form/estimates/page','payments','expenses/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span>المبيعات</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li>
                            <a class="{{set_active(['create/estimate/page','form/estimates/page'])}} {{ request()->is('edit/estimate/*') ? 'active' : '' }}{{ request()->is('estimate/view/*') ? 'active' : '' }}"
                               href="{{ route('form/estimates/page') }}">
                                التقديرات
                            </a>
                        </li>
                        <li><a class="{{set_active(['payments'])}}" href="{{ route('payments') }}">المدفوعات</a></li>
                        <li><a class="{{set_active(['expenses/page'])}}" href="{{ route('expenses/page') }}">المصروفات</a></li>
                    </ul>
                </li>

                <li class="{{set_active(['form/salary/page','form/payroll/items'])}} submenu">
                    <a href="#" class="{{ set_active(['form/salary/page','form/payroll/items']) ? 'noti-dot' : '' }}">
                        <i class="la la-money"></i>
                        <span>الرواتب</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/salary/page'])}}" href="{{ route('form/salary/page') }}">رواتب الموظفين</a></li>
                        <li><a href="{{ route('form/salary/page') }}">قسيمة الراتب</a></li>
                        <li><a class="{{set_active(['form/payroll/items'])}}" href="{{ route('form/payroll/items') }}">بنود الرواتب</a></li>
                    </ul>
                </li>

                <li class="{{set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page','form/payments/reports/page','form/employee/reports/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page','form/payments/reports/page','form/employee/reports/page','form/attendance/reports/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-pie-chart"></i>
                        <span>التقارير</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/expense/reports/page'])}}" href="{{ route('form/expense/reports/page') }}">تقرير المصروفات</a></li>
                        <li><a class="{{set_active(['form/invoice/reports/page'])}}" href="{{ route('form/invoice/reports/page') }}">تقرير الفواتير</a></li>
                        <li><a class="{{set_active(['form/payments/reports/page'])}}" href="{{ route('form/payments/reports/page') }}">تقرير المدفوعات</a></li>
                        <li><a class="{{set_active(['form/employee/reports/page'])}}" href="{{ route('form/employee/reports/page') }}">تقرير الموظفين</a></li>
                        <li><a class="{{set_active(['form/payslip/reports/page'])}}" href="{{ route('form/payslip/reports/page') }}">تقرير قسائم الرواتب</a></li>
                        <li><a class="{{set_active(['form/attendance/reports/page'])}}" href="{{ route('form/attendance/reports/page') }}">تقرير الحضور</a></li>
                        <li><a class="{{set_active(['form/leave/reports/page'])}}" href="{{ route('form/leave/reports/page') }}">تقرير الإجازات</a></li>
                        <li><a class="{{set_active(['form/daily/reports/page'])}}" href="{{ route('form/daily/reports/page') }}">التقرير اليومي</a></li>
                    </ul>
                </li>

                <li class="menu-title">
                    <span>الأداء</span>
                </li>

                <li class="{{set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-graduation-cap"></i>
                        <span>الأداء</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/performance/indicator/page'])}}" href="{{ route('form/performance/indicator/page') }}">مؤشرات الأداء</a></li>
                        <li><a class="{{set_active(['form/performance/page'])}}" href="{{ route('form/performance/page') }}">مراجعة الأداء</a></li>
                        <li><a class="{{set_active(['form/performance/appraisal/page'])}}" href="{{ route('form/performance/appraisal/page') }}">تقييم الأداء</a></li>
                    </ul>
                </li>

                <li class="{{set_active(['form/training/list/page','form/trainers/list/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/training/list/page','form/trainers/list/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-edit"></i>
                        <span>التدريب</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/training/list/page'])}}" href="{{ route('form/training/list/page') }}">قائمة الدورات</a></li>
                        <li><a class="{{set_active(['form/trainers/list/page'])}}" href="{{ route('form/trainers/list/page') }}">المدربون</a></li>
                        <li><a class="{{set_active(['form/training/type/list/page'])}}" href="{{ route('form/training/type/list/page') }}">أنواع التدريب</a></li>
                    </ul>
                </li>

                <li class="menu-title">
                    <span>الإدارة</span>
                </li>

                <li class="{{set_active(['assets/page'])}}">
                    <a href="{{ route('assets/page') }}">
                        <i class="la la-object-ungroup"></i>
                        <span>الأصول</span>
                    </a>
                </li>

                <li class="{{set_active([
                    'user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs',
                    'user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs',
                    'user/dashboard/archived/jobs','user/dashboard/save','jobs','job/applicants','job/details',
                    'page/manage/resumes','page/shortlist/candidates','page/interview/questions','page/offer/approvals',
                    'page/experience/level','page/candidates','page/schedule/timing','page/aptitude/result'
                ])}} submenu">
                    <a href="#" class="{{ set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/save','jobs','job/applicants','job/details']) ? 'noti-dot' : '' }}">
                        <i class="la la-briefcase"></i>
                        <span>الوظائف</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }} {{ (request()->is('job/applicants/*')) ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['user/dashboard/index'])}}" href="{{ route('user/dashboard/index') }}">لوحة تحكم المستخدم</a></li>
                        <li><a class="{{set_active(['jobs/dashboard/index'])}}" href="{{ route('jobs/dashboard/index') }}">لوحة تحكم الوظائف</a></li>
                        <li><a class="{{set_active(['jobs','job/applicants','job/details'])}} {{ (request()->is('job/applicants/*','job/details/*')) ? 'active' : '' }}" href="{{ route('jobs') }}">إدارة الوظائف</a></li>
                        <li><a class="{{set_active(['page/manage/resumes'])}}" href="{{ route('page/manage/resumes') }}">إدارة السير الذاتية</a></li>
                        <li><a class="{{set_active(['page/shortlist/candidates'])}}" href="{{ route('page/shortlist/candidates') }}">قائمة المرشحين المختصرة</a></li>
                        <li><a class="{{set_active(['page/interview/questions'])}}" href="{{ route('page/interview/questions') }}">أسئلة المقابلات</a></li>
                        <li><a class="{{set_active(['page/offer/approvals'])}}" href="{{ route('page/offer/approvals') }}">اعتماد العروض</a></li>
                        <li><a class="{{set_active(['page/experience/level'])}}" href="{{ route('page/experience/level') }}">مستوى الخبرة</a></li>
                        <li><a class="{{set_active(['page/candidates'])}}" href="{{ route('page/candidates') }}">قائمة المرشحين</a></li>
                        <li><a class="{{set_active(['page/schedule/timing'])}}" href="{{ route('page/schedule/timing') }}">جدولة المواعيد</a></li>
                        <li><a class="{{set_active(['page/aptitude/result'])}}" href="{{ route('page/aptitude/result') }}">نتائج القدرات</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- Overlay للموبايل --}}



<div class="sidebar-overlay" id="sidebarOverlay"></div>




{{-- <!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title">
                    <span>الرئيسية</span>
                </li>

                <li class="{{set_active(['home','em/dashboard'])}} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span>لوحة التحكم</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}">لوحة تحكم المدير</a></li>
                        <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}">لوحة تحكم الموظف</a></li>
                    </ul>
                </li>

                @if (Auth::user()->role_name=='Admin')
                <li class="menu-title"><span>إدارة المستخدمين</span></li>

                <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                    <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                        <i class="la la-user-secret"></i>
                        <span>إدارة المستخدمين</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">جميع المستخدمين</a></li>
                    </ul>
                </li>
                @endif

                <li class="menu-title"><span>الموظفون</span></li>

                <li class="{{set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new','form/leaves/employee/new','form/leavesettings/page','attendance/page','attendance/employee/page','form/departments/page','form/designations/page','form/timesheet/page','form/shiftscheduling/page','form/overtime/page'])}} submenu">
                    <a href="#">
                        <i class="la la-user"></i>
                        <span>الموظفون</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all/employee/card') }}">جميع الموظفين</a></li>
                        <li><a href="{{ route('form/holidays/new') }}">الإجازات الرسمية</a></li>
                        <li><a href="{{ route('form/leaves/new') }}">طلبات الإجازة (الإدارة)</a></li>
                        <li><a href="{{route('form/leaves/employee/new')}}">طلبات الإجازة (الموظف)</a></li>
                        <li><a href="{{ route('form/leavesettings/page') }}">إعدادات الإجازات</a></li>
                        <li><a href="{{ route('attendance/page') }}">الحضور والانصراف (الإدارة)</a></li>
                        <li><a href="{{ route('attendance/employee/page') }}">الحضور والانصراف (الموظف)</a></li>
                        <li><a href="{{ route('form/departments/page') }}">الأقسام</a></li>
                        <li><a href="{{ route('form/designations/page') }}">المسميات الوظيفية</a></li>
                        <li><a href="{{ route('form/timesheet/page') }}">سجل الدوام</a></li>
                        <li><a href="{{ route('form/shiftscheduling/page') }}">الجداول والمناوبات</a></li>
                        <li><a href="{{ route('form/overtime/page') }}">العمل الإضافي</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>الموارد البشرية</span></li>

                <li class="{{set_active(['create/estimate/page','form/estimates/page','payments','expenses/page'])}} submenu">
                    <a href="#">
                        <i class="la la-files-o"></i>
                        <span>المبيعات</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('form/estimates/page') }}">التقديرات</a></li>
                        <li><a href="{{ route('payments') }}">المدفوعات</a></li>
                        <li><a href="{{ route('expenses/page') }}">المصروفات</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>الرواتب</span></li>

                <li class="{{set_active(['form/salary/page','form/payroll/items'])}} submenu">
                    <a href="#"><i class="la la-money"></i>
                        <span>الرواتب</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('form/salary/page') }}">رواتب الموظفين</a></li>
                        <li><a href="#">قسائم الرواتب</a></li>
                        <li><a href="{{ route('form/payroll/items') }}">بنود الرواتب</a></li>
                    </ul>
                </li>

                <li class="menu-title"><span>التقارير</span></li>

                <li class="{{set_active(['form/expense/reports/page','form/invoice/reports/page','form/attendance/reports/page'])}} submenu">
                    <a href="#"><i class="la la-pie-chart"></i>
                        <span>التقارير</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('form/expense/reports/page') }}">تقرير المصروفات</a></li>
                        <li><a href="{{ route('form/invoice/reports/page') }}">تقرير الفواتير</a></li>
                        <li><a href="{{ route('form/attendance/reports/page') }}">تقرير الحضور</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar --> --}}





{{-- 
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{set_active(['home','em/dashboard'])}} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span> Dashboard</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}">Admin Dashboard</a></li>
                        <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}">Employee Dashboard</a></li>
                    </ul>
                </li>
                @if (Auth::user()->role_name=='Admin')
                    <li class="menu-title"> <span>Authentication</span> </li>
                    <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                        <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                            <i class="la la-user-secret"></i> <span> User Controller</span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">All User</a></li>
                        </ul>
                    </li>
                @endif
                <li class="menu-title"> <span>Employees</span> </li>
                <li class="{{set_active(['all/employee/list','all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leaves/employee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'])}} submenu">
                    <a href="#" class="{{ set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
                    'form/leaves/employee/new','form/leavesettings/page','attendance/page',
                    'attendance/employee/page','form/departments/page','form/designations/page',
                    'form/timesheet/page','form/shiftscheduling/page','form/overtime/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/employee/list','all/employee/card'])}} {{ request()->is('all/employee/view/edit/*','employee/profile/*') ? 'active' : '' }}" href="{{ route('all/employee/card') }}">All Employees</a></li>
                        <li><a class="{{set_active(['form/holidays/new'])}}" href="{{ route('form/holidays/new') }}">Holidays</a></li>
                        <li><a class="{{set_active(['form/leaves/new'])}}" href="{{ route('form/leaves/new') }}">Leaves (Admin) 
                            <span class="badge badge-pill bg-primary float-right">1</span></a>
                        </li>
                        <li><a class="{{set_active(['form/leaves/employee/new'])}}" href="{{route('form/leaves/employee/new')}}">Leaves (Employee)</a></li>
                        <li><a class="{{set_active(['form/leavesettings/page'])}}" href="{{ route('form/leavesettings/page') }}">Leave Settings</a></li>
                        <li><a class="{{set_active(['attendance/page'])}}" href="{{ route('attendance/page') }}">Attendance (Admin)</a></li>
                        <li><a class="{{set_active(['attendance/employee/page'])}}" href="{{ route('attendance/employee/page') }}">Attendance (Employee)</a></li>
                        <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}">Departments</a></li>
                        <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}">Designations</a></li>
                        <li><a class="{{set_active(['form/timesheet/page'])}}" href="{{ route('form/timesheet/page') }}">Timesheet</a></li>
                        <li><a class="{{set_active(['form/shiftscheduling/page'])}}" href="{{ route('form/shiftscheduling/page') }}">Shift & Schedule</a></li>
                        <li><a class="{{set_active(['form/overtime/page'])}}" href="{{ route('form/overtime/page') }}">Overtime</a></li>
                    </ul>
                </li>
                <li class="menu-title"> <span>HR</span> </li>
                <li class="{{set_active(['create/estimate/page','form/estimates/page','payments','expenses/page'])}} submenu">
                    <a href="#" class="{{ set_active(['create/estimate/page','form/estimates/page','payments','expenses/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span> Sales </span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['create/estimate/page','form/estimates/page'])}} {{ request()->is('edit/estimate/*') ? 'active' : '' }}{{ request()->is('estimate/view/*') ? 'active' : '' }}" href="{{ route('form/estimates/page') }}">Estimates</a></li>
                        <li><a class="{{set_active(['payments'])}}" href="{{ route('payments') }}">Payments</a></li>
                        <li><a class="{{set_active(['expenses/page'])}}" href="{{ route('expenses/page') }}">Expenses</a></li>
                    </ul>
                </li>
                <li class="{{set_active(['form/salary/page','form/payroll/items'])}} submenu">
                    <a href="#" class="{{ set_active(['form/salary/page','form/payroll/items']) ? 'noti-dot' : '' }}"><i class="la la-money"></i>
                    <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/salary/page'])}}" href="{{ route('form/salary/page') }}"> Employee Salary </a></li>
                        <li><a href="{{ route('form/salary/page') }}"> Payslip </a></li>
                        <li><a class="{{set_active(['form/payroll/items'])}}" href="{{ route('form/payroll/items') }}"> Payroll Items </a></li>
                    </ul>
                </li>
                <li class="{{set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page','form/payments/reports/page','form/employee/reports/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page','form/payments/reports/page','form/employee/reports/page','form/attendance/reports/page']) ? 'noti-dot' : '' }}"><i class="la la-pie-chart"></i>
                    <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/expense/reports/page'])}}" href="{{ route('form/expense/reports/page') }}"> Expense Report </a></li>
                        <li><a class="{{set_active(['form/invoice/reports/page'])}}" href="{{ route('form/invoice/reports/page') }}"> Invoice Report </a></li>
                        <li><a class="{{set_active(['form/payments/reports/page'])}}" href="{{ route('form/payments/reports/page') }}"> Payments Report </a></li>
                        <li><a class="{{set_active(['form/employee/reports/page'])}}" href="{{ route('form/employee/reports/page') }}"> Employee Report </a></li>
                        <li><a class="{{set_active(['form/payslip/reports/page'])}}" href="{{ route('form/payslip/reports/page') }}"> Payslip Report </a></li>
                        <li><a class="{{set_active(['form/attendance/reports/page'])}}" href="{{ route('form/attendance/reports/page') }}"> Attendance Report </a></li>
                        <li><a class="{{set_active(['form/leave/reports/page'])}}" href="{{ route('form/leave/reports/page') }}"> Leave Report </a></li>
                        <li><a class="{{set_active(['form/daily/reports/page'])}}" href="{{ route('form/daily/reports/page') }}"> Daily Report </a></li>
                    </ul>
                </li>
                <li class="menu-title"> <span>Performance</span> </li>
                <li class="{{set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page']) ? 'noti-dot' : '' }}"><i class="la la-graduation-cap"></i>
                    <span> Performance </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/performance/indicator/page'])}}" href="{{ route('form/performance/indicator/page') }}"> Performance Indicator </a></li>
                        <li><a class="{{set_active(['form/performance/page'])}}" href="{{ route('form/performance/page') }}"> Performance Review </a></li>
                        <li><a class="{{set_active(['form/performance/appraisal/page'])}}" href="{{ route('form/performance/appraisal/page') }}"> Performance Appraisal </a></li>
                    </ul>
                </li>
                <li class="{{set_active(['form/training/list/page','form/trainers/list/page'])}} submenu"> 
                    <a href="#" class="{{ set_active(['form/training/list/page','form/trainers/list/page']) ? 'noti-dot' : '' }}"><i class="la la-edit"></i>
                    <span> Training </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/training/list/page'])}}" href="{{ route('form/training/list/page') }}"> Training List </a></li>
                        <li><a class="{{set_active(['form/trainers/list/page'])}}" href="{{ route('form/trainers/list/page') }}"> Trainers</a></li>
                        <li><a class="{{set_active(['form/training/type/list/page'])}}" href="{{ route('form/training/type/list/page') }}"> Training Type </a></li>
                    </ul>
                </li>

                <li class="menu-title"> <span>Administration</span> </li>
                <li class="{{set_active(['assets/page'])}}"> <a href="{{ route('assets/page') }}"><i class="la la-object-ungroup">
                    </i> <span>Assets</span></a>
                </li>

                <li class="{{set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs','user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs','user/dashboard/archived/jobs','user/dashboard/save','jobs','job/applicants','job/details','page/manage/resumes','page/shortlist/candidates','page/interview/questions','page/offer/approvals','page/experience/level','page/candidates','page/schedule/timing','page/aptitude/result'])}} submenu">
                    <a href="#" class="{{ set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/save','jobs','job/applicants','job/details']) ? 'noti-dot' : '' }}"><i class="la la-briefcase"></i>
                        <span> Jobs </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }} {{ (request()->is('job/applicants/*')) ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['user/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs','user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs','user/dashboard/archived/jobs','user/dashboard/save'])}}" href="{{ route('user/dashboard/index') }}"> User Dasboard </a></li>
                        <li><a class="{{set_active(['jobs/dashboard/index'])}}" href="{{ route('jobs/dashboard/index') }}"> Jobs Dasboard </a></li>
                        <li><a class="{{set_active(['jobs','job/applicants','job/details'])}} {{ (request()->is('job/applicants/*','job/details/*')) ? 'active' : '' }}" href="{{ route('jobs') }} "> Manage Jobs </a></li>
                        <li><a class="{{set_active(['page/manage/resumes'])}}" href="{{ route('page/manage/resumes') }}"> Manage Resumes </a></li>
                        <li><a class="{{set_active(['page/shortlist/candidates'])}}" href="{{ route('page/shortlist/candidates') }}"> Shortlist Candidates </a></li>
                        <li><a class="{{set_active(['page/interview/questions'])}}" href="{{ route('page/interview/questions') }}"> Interview Questions </a></li>
                        <li><a class="{{set_active(['page/offer/approvals'])}}" href="{{ route('page/offer/approvals') }}"> Offer Approvals </a></li>
                        <li><a class="{{set_active(['page/experience/level'])}}" href="{{ route('page/experience/level') }}"> Experience Level </a></li>
                        <li><a class="{{set_active(['page/candidates'])}}" href="{{ route('page/candidates') }}"> Candidates List </a></li>
                        <li><a class="{{set_active(['page/schedule/timing'])}}" href="{{ route('page/schedule/timing') }}"> Schedule timing </a></li>
                        <li><a class="{{set_active(['page/aptitude/result'])}}" href="{{ route('page/aptitude/result') }}"> Aptitude Results </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar --> --}}
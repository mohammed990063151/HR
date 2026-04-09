{{-- ===================================================
     SIDEBAR - خط عربي جذاب + فتح/إغلاق سلس
     =================================================== --}}

{{-- خط Cairo: يُحمّل أيضاً من layouts/master — هنا للتأكيد عند تضمين السيدبار منفرداً --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ── متغيرات الألوان ─────────────────────────── */
:root {
    --sidebar-bg:        #0f172a;
    --sidebar-width:     260px;
    --sidebar-collapsed: 68px;
    --app-header-height: 72px;
    --accent:            #6366f1;
    --accent-light:      #818cf8;
    --accent-glow:       rgba(99,102,241,0.18);
    --text-primary:      #f1f5f9;
    --text-muted:        #94a3b8;
    --item-hover:        rgba(99,102,241,0.12);
    --item-active:       rgba(99,102,241,0.22);
    --border:            rgba(148,163,184,0.08);
    --title-color:       #475569;
    --transition:        0.3s cubic-bezier(0.4,0,0.2,1);
}

/* ── الخطوط ──────────────────────────────────── */
#sidebar,
#sidebar * {
    font-family: 'Cairo', sans-serif !important;
}

/* ── الهيكل الأساسي — يبدأ أسفل الهيدر الثابت ──────────────────────────── */
#sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    position: fixed;
    top: var(--app-header-height);
    right: 0;
    height: calc(100vh - var(--app-header-height));
    z-index: 1000;
    transition: width var(--transition);
    overflow: hidden;
    border-left: 1px solid var(--border);
    box-shadow: -4px 0 30px rgba(0,0,0,0.4);
    direction: rtl;
}

/* ── حالة الإغلاق ────────────────────────────── */
#sidebar.sidebar-collapsed {
    width: var(--sidebar-collapsed);
}

#sidebar.sidebar-collapsed .menu-title,
#sidebar.sidebar-collapsed .menu-arrow,
#sidebar.sidebar-collapsed a > span:not(.badge),
#sidebar.sidebar-collapsed .noti-dot::after {
    opacity: 0;
    width: 0;
    overflow: hidden;
    transition: opacity var(--transition), width var(--transition);
}

#sidebar.sidebar-collapsed .sidebar-inner {
    overflow: visible;
}

/* ── النصوص في الوضع المفتوح ──────────────────── */
#sidebar a > span,
#sidebar .menu-title {
    opacity: 1;
    transition: opacity var(--transition);
    white-space: nowrap;
}

/* ── زر التبديل ──────────────────────────────── */
#sidebar-toggle-btn {
    position: fixed;
    top: calc(var(--app-header-height) + 14px);
    right: calc(var(--sidebar-width) - 14px);
    z-index: 1100;
    width: 28px;
    height: 28px;
    background: var(--accent);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 12px rgba(99,102,241,0.5);
    transition: right var(--transition), transform var(--transition), background var(--transition);
    padding: 0;
}

#sidebar-toggle-btn:hover {
    background: var(--accent-light);
    box-shadow: 0 4px 20px rgba(99,102,241,0.7);
}

body.sidebar-collapsed-body #sidebar-toggle-btn {
    right: calc(var(--sidebar-collapsed) - 14px);
    transform: rotate(180deg);
}

#sidebar-toggle-btn svg {
    width: 14px; height: 14px;
    fill: #fff;
    transition: transform var(--transition);
}

/* ── الشريط الداخلي ──────────────────────────── */
.sidebar-inner {
    height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    padding-bottom: 24px;
    scrollbar-width: thin;
    scrollbar-color: var(--accent) transparent;
}

.sidebar-inner::-webkit-scrollbar { width: 3px; }
.sidebar-inner::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 4px; }

/* ── شعار / رأس السيدبار ─────────────────────── */
.sidebar-logo {
    padding: 22px 18px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 8px;
    min-height: 68px;
}

.sidebar-logo .logo-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--accent), #a78bfa);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
    box-shadow: 0 4px 14px var(--accent-glow);
}

.sidebar-logo .logo-text {
    font-family: 'Cairo', sans-serif !important;
    font-size: 17px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.3px;
    transition: opacity var(--transition);
    white-space: nowrap;
}

#sidebar.sidebar-collapsed .logo-text { opacity: 0; width: 0; overflow: hidden; }

/* ── عناوين الأقسام ──────────────────────────── */
.sidebar-menu .menu-title {
    padding: 18px 18px 6px;
    overflow: hidden;
    transition: all var(--transition);
    height: 40px;
}

.sidebar-menu .menu-title span {
    font-family: 'Cairo', sans-serif !important;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--title-color);
    display: block;
    transition: opacity var(--transition);
}

#sidebar.sidebar-collapsed .menu-title {
    height: 10px;
    padding: 5px 0;
}

/* ── روابط القائمة ───────────────────────────── */
.sidebar-menu ul { list-style: none; margin: 0; padding: 0 8px; }

.sidebar-menu > ul { padding: 0 8px 0; }

.sidebar-menu li > a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 10px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    position: relative;
    white-space: nowrap;
    cursor: pointer;
    margin-bottom: 2px;
}

.sidebar-menu li > a:hover {
    background: var(--item-hover);
    color: var(--text-primary);
    transform: translateX(-2px);
}

.sidebar-menu li > a.active,
.sidebar-menu li.active > a {
    background: var(--item-active);
    color: #fff;
}

.sidebar-menu li > a.active::before,
.sidebar-menu li.active > a::before {
    content: '';
    position: absolute;
    right: 0; top: 50%;
    transform: translateY(-50%);
    width: 3px; height: 60%;
    background: var(--accent);
    border-radius: 2px 0 0 2px;
}

/* ── الأيقونات ───────────────────────────────── */
.sidebar-menu li > a > i,
.sidebar-menu li > a > .menu-icon {
    font-size: 18px;
    width: 22px;
    text-align: center;
    flex-shrink: 0;
    transition: color 0.2s;
}

.sidebar-menu li > a:hover > i { color: var(--accent-light); }
.sidebar-menu li.active > a > i,
.sidebar-menu li > a.active > i { color: var(--accent-light); }

/* ── سهم القائمة الفرعية ─────────────────────── */
.menu-arrow {
    margin-right: auto !important;
    margin-left: 0 !important;
    font-size: 11px;
    opacity: 0.5;
    transition: transform 0.25s ease, opacity var(--transition);
    flex-shrink: 0;
}

.menu-arrow::before {
    content: '\f107';
    font-family: 'FontAwesome';
}

.submenu.open > a .menu-arrow,
.submenu > a[aria-expanded="true"] .menu-arrow {
    transform: rotate(180deg);
    opacity: 1;
}

/* ── القائمة الفرعية ─────────────────────────── */
.sidebar-menu .submenu > ul {
    padding: 2px 0 4px 0;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.35s cubic-bezier(0.4,0,0.2,1);
}

.sidebar-menu .submenu.open > ul {
    max-height: 600px;
}

.sidebar-menu .submenu > ul li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px 8px 12px;
    font-size: 13px;
    font-weight: 400;
    color: var(--text-muted);
    border-radius: 8px;
    margin-right: 28px;
    position: relative;
}
.sidebar-menu .submenu > ul li a > i.submenu-ico {
    font-size: 16px;
    width: 22px;
    text-align: center;
    opacity: 0.9;
    flex-shrink: 0;
    color: var(--accent-light);
}

.sidebar-menu .submenu > ul li a::before {
    content: '';
    position: absolute;
    right: -14px; top: 50%;
    transform: translateY(-50%);
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--border);
    transition: background 0.2s;
}

.sidebar-menu .submenu > ul li a:hover::before,
.sidebar-menu .submenu > ul li a.active::before {
    background: var(--accent);
}

.sidebar-menu .submenu > ul li a:hover {
    color: var(--text-primary);
    background: var(--item-hover);
    transform: translateX(-2px);
}

.sidebar-menu .submenu > ul li a.active {
    color: #fff;
    background: transparent;
}

/* ── Badge ───────────────────────────────────── */
.badge {
    font-family: 'Cairo', sans-serif !important;
    font-size: 10px !important;
    padding: 2px 6px !important;
    border-radius: 20px !important;
    margin-right: auto;
    flex-shrink: 0;
}

/* ── noti-dot ────────────────────────────────── */
.noti-dot { position: relative; }
.noti-dot::after {
    content: '';
    position: absolute;
    top: 10px; left: 10px;
    width: 6px; height: 6px;
    background: var(--accent);
    border-radius: 50%;
    box-shadow: 0 0 0 2px rgba(99,102,241,0.3);
    transition: opacity var(--transition);
}

/* ── Overlay ─────────────────────────────────── */
#sidebarOverlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    backdrop-filter: blur(2px);
}

@media (max-width: 768px) {
    #sidebar {
        width: var(--sidebar-width) !important;
        top: var(--app-header-height);
        height: calc(100vh - var(--app-header-height));
        right: calc(-1 * var(--sidebar-width));
        transition: right var(--transition);
    }
    #sidebar.mobile-open {
        right: 0;
    }
    #sidebar.mobile-open ~ #sidebarOverlay,
    body.mobile-sidebar-open #sidebarOverlay {
        display: block;
    }
    #sidebar-toggle-btn {
        right: 12px;
        top: calc(var(--app-header-height) + 10px);
    }
    body.mobile-sidebar-open #sidebar-toggle-btn {
        right: calc(var(--sidebar-width) - 14px);
    }
}

/* ── تعديل المحتوى الرئيسي ───────────────────── */
.page-wrapper {
    margin-right: var(--sidebar-width);
    transition: margin-right var(--transition);
}
body.sidebar-collapsed-body .page-wrapper {
    margin-right: var(--sidebar-collapsed);
}
@media (max-width: 768px) {
    .page-wrapper { margin-right: 0 !important; }
}
</style>

{{-- ── زر التبديل خارج الـ Sidebar ────────────── --}}
<button id="sidebar-toggle-btn" title="فتح/إغلاق القائمة" aria-label="toggle sidebar">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M15 18l-6-6 6-6"/>
    </svg>
</button>

{{-- ── السيدبار الرئيسي ─────────────────────── --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">

        {{-- شعار --}}
        <div class="sidebar-logo">
            <div class="logo-icon">🏢</div>
            <span class="logo-text">نظام الموارد البشرية</span>
        </div>

        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                {{-- ── الرئيسية ────────────────────────── --}}
                <li class="menu-title"><span>الرئيسية</span></li>

                <li class="{{set_active(['home','em/dashboard'])}} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span>لوحة التحكم</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}"><i class="la la-tachometer-alt submenu-ico"></i><span>لوحة تحكم المدير</span></a></li>
                        <li><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}"><i class="la la-user-tie submenu-ico"></i><span>لوحة تحكم الموظف</span></a></li>
                    </ul>
                </li>

                {{-- ── الحضور والمواقع (بوابة + إدارة دوائر GPS) ───────────────── --}}
                <li class="menu-title"><span>الحضور والمواقع</span></li>

                <li class="submenu {{ sidebar_portal_zone_active() ? 'open' : '' }}">
                    <a href="#" class="{{ sidebar_portal_zone_active() ? 'active' : '' }}">
                        <i class="la la-map-marked-alt"></i>
                        <span>البوابة والمواقع</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('portal') ? 'active' : '' }}" href="{{ route('portal.index') }}">
                                <i class="la la-door-open submenu-ico"></i>
                                <span>بوابة الموظف <small style="opacity:.75;">(حضور/انصراف)</small></span>
                            </a>
                        </li>
                        @if (user_is_admin())
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/locations') ? 'active' : '' }}" href="{{ route('admin.locations.index') }}">
                                    <i class="la la-globe submenu-ico"></i>
                                    <span>إدارة المواقع الجغرافية</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/requests') ? 'active' : '' }}" href="{{ route('admin.requests.index') }}">
                                    <i class="la la-inbox submenu-ico"></i>
                                    <span>طلبات الموظفين</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/attendance') ? 'active' : '' }}" href="{{ route('admin.attendance.index') }}">
                                    <i class="la la-calendar-check submenu-ico"></i>
                                    <span>حضور جميع الموظفين</span>
                                    <span class="badge bg-success">جديد</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/portal-content') ? 'active' : '' }}" href="{{ route('admin.portal-content.index') }}">
                                    <i class="la la-bullhorn submenu-ico"></i>
                                    <span>إعلانات ومناسبات الموظفين</span>
                                    <span class="badge bg-success">جديد</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/portal-balances') ? 'active' : '' }}" href="{{ route('admin.portal-balances.index') }}">
                                    <i class="la la-wallet submenu-ico"></i>
                                    <span>رصيد بوابة الموظف</span>
                                    <span class="badge bg-success">جديد</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/work-periods') ? 'active' : '' }}" href="{{ route('admin.work-periods.index') }}">
                                    <i class="la la-clock submenu-ico"></i>
                                    <span>فترات العمل</span>
                                    <span class="badge bg-success">جديد</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ str_starts_with(request()->path(), 'admin/request-types') ? 'active' : '' }}" href="{{ route('admin.request-types.index') }}">
                                    <i class="la la-tags submenu-ico"></i>
                                    <span>أنواع الطلبات</span>
                                    <span class="badge bg-success">جديد</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                {{-- ── الصلاحيات ───────────────────────── --}}
                @if (user_is_admin())
                    <li class="menu-title"><span>الصلاحيات</span></li>

                    <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                        <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                            <i class="la la-user-secret"></i>
                            <span>إدارة المستخدمين</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">جميع المستخدمين</a></li>
                        </ul>
                    </li>
                @endif

                {{-- ── الموظفون ─────────────────────────── --}}
                <li class="menu-title"><span>الموظفون</span></li>

                <li class="{{set_active([
                    'all/employee/list','all/employee/card','form/holidays/new','form/leaves/new',
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
                    <ul>
                        <li><a class="{{set_active(['all/employee/list','all/employee/card'])}} {{ request()->is('all/employee/view/edit/*','employee/profile/*') ? 'active' : '' }}"
                               href="{{ route('all/employee/card') }}">جميع الموظفين</a></li>
                        <li><a class="{{set_active(['form/holidays/new'])}}" href="{{ route('form/holidays/new') }}">الإجازات</a></li>
                        <li><a class="{{set_active(['form/leaves/new'])}}" href="{{ route('form/leaves/new') }}">
                            طلبات الإجازة (الإدارة)
                            <span class="badge bg-primary">1</span>
                        </a></li>
                        <li><a class="{{set_active(['form/leaves/employee/new'])}}" href="{{route('form/leaves/employee/new')}}">طلبات الإجازة (الموظف)</a></li>
                        <li><a class="{{set_active(['form/leavesettings/page'])}}" href="{{ route('form/leavesettings/page') }}">إعدادات الإجازات</a></li>
                        <li><a class="{{set_active(['attendance/page'])}}" href="{{ route('attendance/page') }}">الحضور (الإدارة)</a></li>
                        <li><a class="{{set_active(['attendance/employee/page'])}}" href="{{ route('attendance/employee/page') }}">الحضور (الموظف)</a></li>
                        <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}">الأقسام</a></li>
                        <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}">المسميات الوظيفية</a></li>
                        <li><a class="{{set_active(['form/timesheet/page'])}}" href="{{ route('form/timesheet/page') }}">سجل الدوام</a></li>
                        <li><a class="{{set_active(['form/shiftscheduling/page'])}}" href="{{ route('form/shiftscheduling/page') }}">الجداول والمناوبات</a></li>
                        <li><a class="{{set_active(['form/overtime/page'])}}" href="{{ route('form/overtime/page') }}">العمل الإضافي</a></li>
                    </ul>
                </li>

                {{-- ── المبيعات والمالية ──────────────────── --}}
                <li class="menu-title"><span>المبيعات والمالية</span></li>

                <li class="{{set_active(['create/estimate/page','form/estimates/page','payments','expenses/page'])}} submenu">
                    <a href="#" class="{{ set_active(['create/estimate/page','form/estimates/page','payments','expenses/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span>التقديرات والمدفوعات</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['create/estimate/page','form/estimates/page'])}} {{ request()->is('edit/estimate/*','estimate/view/*') ? 'active' : '' }}"
                               href="{{ route('form/estimates/page') }}">التقديرات</a></li>
                        <li><a class="{{set_active(['payments'])}}" href="{{ route('payments') }}">المدفوعات</a></li>
                        <li><a class="{{set_active(['expenses/page'])}}" href="{{ route('expenses/page') }}">المصروفات</a></li>
                    </ul>
                </li>

                {{-- ── الرواتب ──────────────────────────── --}}
                <li class="menu-title"><span>الرواتب</span></li>

                <li class="{{set_active(['form/salary/page','form/payroll/items'])}} submenu">
                    <a href="#" class="{{ set_active(['form/salary/page','form/payroll/items']) ? 'noti-dot' : '' }}">
                        <i class="la la-money"></i>
                        <span>الرواتب</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['form/salary/page'])}}" href="{{ route('form/salary/page') }}">رواتب الموظفين</a></li>
                        <li><a href="{{ route('form/salary/page') }}">قسيمة الراتب</a></li>
                        <li><a class="{{set_active(['form/payroll/items'])}}" href="{{ route('form/payroll/items') }}">بنود الرواتب</a></li>
                    </ul>
                </li>

                {{-- ── التقارير ─────────────────────────── --}}
                <li class="menu-title"><span>التقارير</span></li>

                <li class="{{set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page','form/payments/reports/page','form/employee/reports/page','form/attendance/reports/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/expense/reports/page','form/invoice/reports/page','form/leave/reports/page','form/daily/reports/page','form/payments/reports/page','form/employee/reports/page','form/attendance/reports/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-pie-chart"></i>
                        <span>التقارير</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['form/expense/reports/page'])}}"  href="{{ route('form/expense/reports/page') }}">تقرير المصروفات</a></li>
                        <li><a class="{{set_active(['form/invoice/reports/page'])}}"  href="{{ route('form/invoice/reports/page') }}">تقرير الفواتير</a></li>
                        <li><a class="{{set_active(['form/payments/reports/page'])}}" href="{{ route('form/payments/reports/page') }}">تقرير المدفوعات</a></li>
                        <li><a class="{{set_active(['form/employee/reports/page'])}}" href="{{ route('form/employee/reports/page') }}">تقرير الموظفين</a></li>
                        <li><a class="{{set_active(['form/payslip/reports/page'])}}"  href="{{ route('form/payslip/reports/page') }}">تقرير قسائم الرواتب</a></li>
                        <li><a class="{{set_active(['form/attendance/reports/page'])}}" href="{{ route('form/attendance/reports/page') }}">تقرير الحضور</a></li>
                        <li><a class="{{set_active(['form/leave/reports/page'])}}"    href="{{ route('form/leave/reports/page') }}">تقرير الإجازات</a></li>
                        <li><a class="{{set_active(['form/daily/reports/page'])}}"    href="{{ route('form/daily/reports/page') }}">التقرير اليومي</a></li>
                    </ul>
                </li>

                {{-- ── الأداء ───────────────────────────── --}}
                <li class="menu-title"><span>الأداء</span></li>

                <li class="{{set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/performance/indicator/page','form/performance/page','form/performance/appraisal/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-graduation-cap"></i>
                        <span>الأداء</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['form/performance/indicator/page'])}}" href="{{ route('form/performance/indicator/page') }}">مؤشرات الأداء</a></li>
                        <li><a class="{{set_active(['form/performance/page'])}}"            href="{{ route('form/performance/page') }}">مراجعة الأداء</a></li>
                        <li><a class="{{set_active(['form/performance/appraisal/page'])}}"  href="{{ route('form/performance/appraisal/page') }}">تقييم الأداء</a></li>
                    </ul>
                </li>

                <li class="{{set_active(['form/training/list/page','form/trainers/list/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/training/list/page','form/trainers/list/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-edit"></i>
                        <span>التدريب</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['form/training/list/page'])}}"      href="{{ route('form/training/list/page') }}">قائمة الدورات</a></li>
                        <li><a class="{{set_active(['form/trainers/list/page'])}}"      href="{{ route('form/trainers/list/page') }}">المدربون</a></li>
                        <li><a class="{{set_active(['form/training/type/list/page'])}}" href="{{ route('form/training/type/list/page') }}">أنواع التدريب</a></li>
                    </ul>
                </li>

                {{-- ── الإدارة ───────────────────────────── --}}
                <li class="menu-title"><span>الإدارة</span></li>

                <li class="{{set_active(['assets/page'])}}">
                    <a href="{{ route('assets/page') }}">
                        <i class="la la-object-ungroup"></i>
                        <span>الأصول</span>
                    </a>
                </li>

                <li class="{{set_active(['user/dashboard/index','jobs/dashboard/index','jobs','job/applicants','job/details','page/manage/resumes','page/shortlist/candidates','page/interview/questions','page/offer/approvals','page/experience/level','page/candidates','page/schedule/timing','page/aptitude/result'])}} submenu">
                    <a href="#" class="{{ set_active(['user/dashboard/index','jobs/dashboard/index','jobs','job/applicants','job/details']) ? 'noti-dot' : '' }}">
                        <i class="la la-briefcase"></i>
                        <span>الوظائف</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['user/dashboard/index'])}}"        href="{{ route('user/dashboard/index') }}">لوحة تحكم المستخدم</a></li>
                        <li><a class="{{set_active(['jobs/dashboard/index'])}}"        href="{{ route('jobs/dashboard/index') }}">لوحة تحكم الوظائف</a></li>
                        <li><a class="{{set_active(['jobs','job/applicants','job/details'])}} {{ request()->is('job/applicants/*','job/details/*') ? 'active' : '' }}"
                               href="{{ route('jobs') }}">إدارة الوظائف</a></li>
                        <li><a class="{{set_active(['page/manage/resumes'])}}"         href="{{ route('page/manage/resumes') }}">إدارة السير الذاتية</a></li>
                        <li><a class="{{set_active(['page/shortlist/candidates'])}}"   href="{{ route('page/shortlist/candidates') }}">المرشحون المختارون</a></li>
                        <li><a class="{{set_active(['page/interview/questions'])}}"    href="{{ route('page/interview/questions') }}">أسئلة المقابلات</a></li>
                        <li><a class="{{set_active(['page/offer/approvals'])}}"        href="{{ route('page/offer/approvals') }}">اعتماد العروض</a></li>
                        <li><a class="{{set_active(['page/experience/level'])}}"       href="{{ route('page/experience/level') }}">مستوى الخبرة</a></li>
                        <li><a class="{{set_active(['page/candidates'])}}"             href="{{ route('page/candidates') }}">قائمة المرشحين</a></li>
                        <li><a class="{{set_active(['page/schedule/timing'])}}"        href="{{ route('page/schedule/timing') }}">جدولة المواعيد</a></li>
                        <li><a class="{{set_active(['page/aptitude/result'])}}"        href="{{ route('page/aptitude/result') }}">نتائج القدرات</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- ── JavaScript: فتح/إغلاق السيدبار ─────────── --}}
<script>
(function () {
    const sidebar   = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const overlay   = document.getElementById('sidebarOverlay');
    const body      = document.body;
    const isMobile  = () => window.innerWidth <= 768;

    // ── استعادة الحالة المحفوظة ──────────────────
    const saved = localStorage.getItem('sidebarCollapsed');
    if (saved === 'true' && !isMobile()) {
        sidebar.classList.add('sidebar-collapsed');
        body.classList.add('sidebar-collapsed-body');
    }

    // ── زر التبديل ───────────────────────────────
    toggleBtn.addEventListener('click', function () {
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
            body.classList.toggle('mobile-sidebar-open');
            overlay.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
        } else {
            const isCollapsed = sidebar.classList.toggle('sidebar-collapsed');
            body.classList.toggle('sidebar-collapsed-body', isCollapsed);
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }
    });

    // ── إغلاق عند النقر على الـ overlay (موبايل) ─
    overlay.addEventListener('click', function () {
        sidebar.classList.remove('mobile-open');
        body.classList.remove('mobile-sidebar-open');
        overlay.style.display = 'none';
    });

    // ── فتح/إغلاق القوائم الفرعية ────────────────
    document.querySelectorAll('#sidebar-menu .submenu > a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // في وضع الإغلاق لا تفتح القوائم
            if (sidebar.classList.contains('sidebar-collapsed') && !isMobile()) return;

            const parent = this.closest('.submenu');
            const isOpen = parent.classList.contains('open');

            // أغلق كل القوائم المفتوحة في نفس المستوى
            const siblings = parent.parentElement.querySelectorAll(':scope > .submenu.open');
            siblings.forEach(function (s) {
                if (s !== parent) s.classList.remove('open');
            });

            parent.classList.toggle('open', !isOpen);
        });
    });

    // ── افتح القائمة النشطة تلقائياً ─────────────
    document.querySelectorAll('#sidebar-menu .submenu').forEach(function (item) {
        if (item.querySelector('a.active')) {
            item.classList.add('open');
        }
    });

    // ── تحديث عند تغيير حجم الشاشة ──────────────
    window.addEventListener('resize', function () {
        if (!isMobile()) {
            sidebar.classList.remove('mobile-open');
            body.classList.remove('mobile-sidebar-open');
            overlay.style.display = 'none';

            const saved = localStorage.getItem('sidebarCollapsed');
            if (saved === 'true') {
                sidebar.classList.add('sidebar-collapsed');
                body.classList.add('sidebar-collapsed-body');
            }
        }
    });
})();
</script>
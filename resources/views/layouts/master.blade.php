<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="SoengSouy Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
	<meta name="author" content="SoengSouy Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Dashboard - HRMS</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('assets/img/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap.min.css') }}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/font-awesome.min.css') }}">
	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/line-awesome.min.css') }}">
	<!-- Datatable CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/dataTables.bootstrap4.min.css') }}">
	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/select2.min.css') }}">
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.css') }}">
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/css/custom-rtl.css') }}">
	<link rel="stylesheet" href="{{ URL::to('assets/css/app-arabic.css') }}">

</head>

<body class="rtl-layout">
	@yield('style')
	<style>
:root {
	--app-header-height: 72px;
	--app-sidebar-width: 260px;
}
/* RTL + خط القالب (Cairo يُكمّل من app-arabic.css) */
html[dir="rtl"] body { direction: rtl; text-align: right; font-family: "Cairo", "Segoe UI", Tahoma, sans-serif; }

/* هيكل عام: فصل واضح بين الهيدر والمحتوى */
.main-wrapper {
	min-height: 100vh;
	display: flex;
	flex-direction: column;
	background: #f1f5f9;
}
.app-header {
	position: sticky;
	top: 0;
	z-index: 1040;
	flex-shrink: 0;
	background: #fff;
	border-bottom: 1px solid #e2e8f0;
	box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
	min-height: var(--app-header-height);
}

/* Sidebar Container */
.sidebar {
  background: #0f172a;              /* كحلي مودرن */
  box-shadow: 0 10px 30px rgba(0,0,0,.18);
  border-left: 1px solid rgba(255,255,255,.06);
}

/* Sidebar inner spacing */
#sidebar-menu {
  padding: 12px 10px;
}

/* Section titles */
.sidebar .menu-title {
  padding: 14px 12px 8px;
  margin-top: 6px;
}
.sidebar .menu-title span {
  color: rgba(255,255,255,.55);
  font-size: 12px;
  letter-spacing: .4px;
  text-transform: none;
}

/* Main links */
.sidebar-menu ul li a {
  display: flex;
  align-items: center;
  gap: 10px;
  color: rgba(255,255,255,.82);
  padding: 10px 12px;
  margin: 6px 6px;
  border-radius: 12px;
  transition: .2s ease;
  font-weight: 500;
  line-height: 1.2;
}

/* Icons */
.sidebar-menu ul li a i {
  font-size: 18px;
  width: 22px;
  text-align: center;
  opacity: .95;
}

/* Hover */
.sidebar-menu ul li a:hover {
  background: rgba(255,255,255,.08);
  transform: translateY(-1px);
}

/* Active state (مع set_active) */
.sidebar-menu ul li.active > a,
.sidebar-menu ul li a.active {
  background: linear-gradient(135deg, rgba(59,130,246,.22), rgba(99,102,241,.18));
  border: 1px solid rgba(59,130,246,.25);
  color: #fff;
}

/* Submenu */
.sidebar-menu .submenu > ul {
  padding: 6px 0 10px;
  margin: 0 6px 10px;
  border-radius: 12px;
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.06);
}

.sidebar-menu .submenu ul li a {
  margin: 4px 8px;
  padding: 9px 12px;
  border-radius: 10px;
  font-weight: 500;
  color: rgba(255,255,255,.78);
}

/* Submenu hover */
.sidebar-menu .submenu ul li a:hover {
  background: rgba(255,255,255,.07);
}

/* Badge */
.sidebar .badge {
  font-weight: 700;
  border-radius: 999px;
  padding: 6px 10px;
}

/* Arrow (RTL/LTR friendly) */
.sidebar-menu .menu-arrow:before {
  color: rgba(255,255,255,.55);
}
html[dir="rtl"] .sidebar-menu .menu-arrow { margin-right: auto; margin-left: 0; }
html[dir="ltr"] .sidebar-menu .menu-arrow { margin-left: auto; margin-right: 0; }

/* Make content spacing nicer (لو السايدبار ثابت) */
.page-wrapper, .main-content {
  background: #f6f7fb;
}

/* Optional: reduce harsh scrollbar look */
.sidebar-inner.slimscroll {
  scrollbar-width: thin;
}

/* Sidebar position fix */
.sidebar {
    right: 0;
    left: auto;
}

/* Content spacing — يُكمّل مع السيدبار في sidebar.blade */
.main-content,
.page-wrapper {
    margin-right: var(--app-sidebar-width);
    margin-left: 0;
}
@media (max-width: 768px) {
	.main-content,
	.page-wrapper {
		margin-right: 0 !important;
	}
}

/* اختصارات داشبورد في الهيدر */
.header-dashboard-shortcuts {
	display: flex;
	align-items: center;
	gap: 6px;
	padding: 4px 8px;
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
}
.header-dashboard-shortcuts .hdr-shortcut {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 40px;
	height: 40px;
	border-radius: 10px;
	color: #64748b;
	background: #fff;
	border: 1px solid #e2e8f0;
	transition: color .2s, background .2s, border-color .2s, transform .15s;
	text-decoration: none !important;
}
.header-dashboard-shortcuts .hdr-shortcut:hover {
	color: #4f46e5;
	background: rgba(79, 70, 229, 0.08);
	border-color: rgba(79, 70, 229, 0.35);
	transform: translateY(-1px);
}
.header-dashboard-shortcuts .hdr-shortcut i {
	font-size: 1.35rem;
	line-height: 1;
}
.header-dashboard-shortcuts .hdr-shortcut.active {
	color: #4f46e5;
	background: rgba(79, 70, 229, 0.12);
	border-color: #4f46e5;
}

</style>
	<style>    
		.invalid-feedback{
			font-size: 14px;
		}
		.error{
			color: red;
		}
	</style>
	<style>
		/* RTL base */
/* html[dir="rtl"] body {
  direction: rtl;
  text-align: right;
} */

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: .75rem;
  flex-wrap: wrap;
  padding: .65rem 1rem;
  min-height: var(--app-header-height);
  height: auto !important;
}

/* left area in RTL becomes visually right */
.header-left { 
  order: 1; 
  display: flex; 
  align-items: center; 
  gap: .5rem;
}

#toggle_btn.desktop-sidebar-toggle {
  order: 2;
  flex-shrink: 0;
}
.page-title-box { 
  order: 3; 
  min-width: 0;
  flex: 1;
}
.header-dashboard-shortcuts {
  order: 4;
}

.user-menu { 
  order: 5; 
  display: flex; 
  align-items: center; 
  gap: .5rem;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  list-style: none;
}

/* search responsive */
.top-nav-search form {
  display: flex;
  align-items: center;
  gap: .35rem;
}

.top-nav-search input {
  width: 180px;
}

/* small screens */
@media (max-width: 992px) {
  .page-title-box { display: none; }
  .header-dashboard-shortcuts { display: none !important; }
  .top-nav-search input { width: 140px; }
}

@media (max-width: 576px) {
  .header { padding: .6rem .75rem; }
  .top-nav-search { display: none; } /* نخفي البحث في الجوال (اختياري) */
  .user-menu { justify-content: flex-start; }
  .header-left { flex: 1; }
}
</style>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<!-- Loader -->
		<div id="loader-wrapper">
			<div id="loader">
				<div class="loader-ellips">
				  <span class="loader-ellips__dot"></span>
				  <span class="loader-ellips__dot"></span>
				  <span class="loader-ellips__dot"></span>
				  <span class="loader-ellips__dot"></span>
				</div>
			</div>
		</div>
		<header class="app-header">
		<div class="header">

  {{-- Logo --}}
  <div class="header-left">
    <a href="{{ route('home') }}" class="logo d-flex align-items-center" title="لوحة التحكم">
      <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}"
           width="40" height="40" alt="شعار" style="border-radius: 50%;">
    </a>

    {{-- Mobile sidebar button --}}
    <a id="mobile_btn" class="mobile_btn d-lg-none ms-2" href="#sidebar" aria-label="فتح القائمة">
      <i class="fa fa-bars"></i>
    </a>
  </div>

  {{-- Desktop toggle --}}
  <a id="toggle_btn" class="d-none d-lg-inline-flex desktop-sidebar-toggle" href="javascript:void(0);" aria-label="تصغير القائمة">
    <span class="bar-icon">
      <span></span><span></span><span></span>
    </span>
  </a>

  {{-- Title --}}
  <div class="page-title-box">
    <h3 class="mb-0 text-truncate" style="max-width: 280px;">مرحبًا، {{ Session::get('name') }}</h3>
  </div>

  {{-- أيقونات داشبورد سريعة --}}
  <div class="header-dashboard-shortcuts d-none d-lg-flex" aria-label="اختصارات لوحة التحكم">
    <a href="{{ route('home') }}" class="hdr-shortcut {{ request()->routeIs('home') ? 'active' : '' }}" title="لوحة المدير">
      <i class="la la-tachometer-alt"></i>
    </a>
    <a href="{{ route('em/dashboard') }}" class="hdr-shortcut {{ request()->routeIs('em/dashboard') ? 'active' : '' }}" title="لوحة الموظف">
      <i class="la la-user-tie"></i>
    </a>
    <a href="{{ route('portal.index') }}" class="hdr-shortcut {{ request()->routeIs('portal.*') ? 'active' : '' }}" title="بوابة الحضور">
      <i class="la la-map-marked-alt"></i>
    </a>
    @if(user_is_admin())
    <a href="{{ route('admin.locations.index') }}" class="hdr-shortcut {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}" title="المواقع الجغرافية">
      <i class="la la-globe"></i>
    </a>
    @endif
  </div>

  {{-- Header Menu --}}
  <ul class="nav user-menu">

    {{-- Search --}}
    <li class="nav-item d-none d-md-block">
      <div class="top-nav-search">
        <form action="#" method="GET">
          <input class="form-control" type="text" placeholder="ابحث هنا...">
          <button class="btn" type="submit" aria-label="بحث">
            <i class="fa fa-search"></i>
          </button>
        </form>
      </div>
    </li>

    {{-- Language --}}
    <li class="nav-item dropdown has-arrow flag-nav">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
        <img src="{{ URL::to('assets/img/flags/sa.jpg') }}" alt="العربية" height="20">
        <span class="ms-1">العربية</span>
      </a>
      <div class="dropdown-menu dropdown-menu-left">
        <a href="javascript:void(0);" class="dropdown-item">
          <img src="{{ URL::to('assets/img/flags/sa.jpg') }}" alt="" height="16"> العربية
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <img src="{{ URL::to('assets/img/flags/us.png') }}" alt="" height="16"> English
        </a>
      </div>
    </li>

    {{-- Notifications --}}
    <li class="nav-item dropdown">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-label="الإشعارات">
        <i class="fa fa-bell-o"></i>
        <span class="badge badge-pill">3</span>
      </a>

      <div class="dropdown-menu notifications dropdown-menu-left">
        <div class="topnav-dropdown-header">
          <span class="notification-title">الإشعارات</span>
          <a href="javascript:void(0)" class="clear-noti">مسح الكل</a>
        </div>

        <div class="noti-content">
          <ul class="notification-list">
            {{-- مثال واحد --}}
            <li class="notification-message">
              <a href="#">
                <div class="media">
                  <span class="avatar">
                    <img alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}">
                  </span>
                  <div class="media-body">
                    <p class="noti-details">
                      تم إضافة مهمة جديدة
                      <span class="noti-title">حجز موعد</span>
                    </p>
                    <p class="noti-time"><span class="notification-time">قبل 4 دقائق</span></p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>

        <div class="topnav-dropdown-footer">
          <a href="#">عرض كل الإشعارات</a>
        </div>
      </div>
    </li>

    {{-- Messages --}}
    <li class="nav-item dropdown">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-label="الرسائل">
        <i class="fa fa-comment-o"></i>
        <span class="badge badge-pill">8</span>
      </a>

      <div class="dropdown-menu notifications dropdown-menu-left">
        <div class="topnav-dropdown-header">
          <span class="notification-title">الرسائل</span>
          <a href="javascript:void(0)" class="clear-noti">مسح الكل</a>
        </div>

        <div class="noti-content">
          <ul class="notification-list">
            <li class="notification-message">
              <a href="#">
                <div class="list-item">
                  <div class="list-left">
                    <span class="avatar">
                      <img alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}">
                    </span>
                  </div>
                  <div class="list-body">
                    <span class="message-author">أحمد</span>
                    <span class="message-time">12:28 ص</span>
                    <div class="clearfix"></div>
                    <span class="message-content">مرحبًا، هل يمكنك متابعة الطلب؟</span>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>

        <div class="topnav-dropdown-footer">
          <a href="#">عرض كل الرسائل</a>
        </div>
      </div>
    </li>

    {{-- Profile --}}
    <li class="nav-item dropdown has-arrow main-drop">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
        <span class="user-img">
          <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="">
          <span class="status online"></span>
        </span>
        <span>{{ Session::get('name') }}</span>
      </a>

      <div class="dropdown-menu dropdown-menu-left">
        <a class="dropdown-item" href="{{ route('profile_user') }}">ملفي الشخصي</a>
        <a class="dropdown-item" href="{{ route('company/settings/page') }}">الإعدادات</a>
        <a class="dropdown-item" href="{{ route('logout') }}">تسجيل الخروج</a>
      </div>
    </li>

  </ul>

</div>
		</header>

		<!-- /Header -->
		<!-- Sidebar -->
		@include('sidebar.sidebar')
		<!-- /Sidebar -->
		<!-- Page Wrapper -->
		@yield('content')
		<!-- /Page Wrapper -->
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ URL::to('assets/js/jquery-3.5.1.min.js') }}"></script>
	<!-- Bootstrap Core JS -->
	<script src="{{ URL::to('assets/js/popper.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
	<!-- Chart JS -->
	<script src="{{ URL::to('assets/plugins/morris/morris.min.js') }}"></script>
	<script src="{{ URL::to('assets/plugins/raphael/raphael.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/chart.js') }}"></script>
	<script src="{{ URL::to('assets/js/Chart.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/line-chart.js') }}"></script>

	<!-- Slimscroll JS -->
	<script src="{{ URL::to('assets/js/jquery.slimscroll.min.js') }}"></script>
	<!-- Select2 JS -->
	<script src="{{ URL::to('assets/js/select2.min.js') }}"></script>
	<!-- Datetimepicker JS -->
	<script src="{{ URL::to('assets/js/moment.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
	<!-- Datatable JS -->
	<script src="{{ URL::to('assets/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/dataTables.bootstrap4.min.js') }}"></script>
	<!-- Multiselect JS -->
	<script src="{{ URL::to('assets/js/multiselect.min.js') }}"></script>
	<!-- validation-->
	<script src="{{ URL::to('assets/js/jquery.validate.js') }}"></script>	
	<!-- Custom JS -->
	<script src="{{ URL::to('assets/js/app.js') }}"></script>
<script>
(function () {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const mobileBtn = document.getElementById('mobile_btn');

  if (!sidebar || !mobileBtn) return;

  function openSidebar() {
    sidebar.classList.add('mobile-open');
    document.body.classList.add('mobile-sidebar-open');
    if (overlay) overlay.style.display = 'block';
  }

  function closeSidebar() {
    sidebar.classList.remove('mobile-open');
    document.body.classList.remove('mobile-sidebar-open');
    if (overlay) overlay.style.display = 'none';
  }

  mobileBtn.addEventListener('click', function(e){
    e.preventDefault();
    if (sidebar.classList.contains('mobile-open')) closeSidebar();
    else openSidebar();
  });

  if (overlay) overlay.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeSidebar();
  });
})();
</script>

	@yield('script')
</body>
</html>
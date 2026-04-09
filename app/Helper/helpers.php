<?php

use Illuminate\Support\Facades\Auth;

/** for side bar menu active */
function set_active($route) {
    if (is_array($route )){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

/** مدير أو سوبر أدمن — للشريط الجانبي والصلاحيات */
function user_is_admin(): bool
{
    $u = Auth::user();
    if (! $u) {
        return false;
    }
    $r = (string) ($u->role_name ?? '');

    return in_array($r, ['Admin', 'Super Admin'], true)
        || str_contains(strtolower($r), 'admin');
}

/** مسارات منطقة البوابة / المواقع في السيدبار */
function sidebar_portal_zone_active(): bool
{
    $p = request()->path();

    return $p === 'portal'
        || str_starts_with($p, 'admin/locations')
        || str_starts_with($p, 'admin/requests')
        || str_starts_with($p, 'admin/attendance')
        || str_starts_with($p, 'admin/portal-content')
        || str_starts_with($p, 'admin/portal-balances')
        || str_starts_with($p, 'admin/work-periods')
        || str_starts_with($p, 'admin/request-types');
}
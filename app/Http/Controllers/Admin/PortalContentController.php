<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalContent;
use Illuminate\Http\Request;

class PortalContentController extends Controller
{
    public function index()
    {
        abort_unless(user_is_admin(), 403);

        $items = PortalContent::query()->orderByDesc('created_at')->paginate(20);

        return view('admin.portal-content.index', compact('items'));
    }

    public function store(Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $data = $request->validate([
            'type' => 'required|in:announcement,occasion',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string|max:3000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        PortalContent::create($data);

        return back()->with('success', 'تمت إضافة العنصر بنجاح.');
    }

    public function toggle(PortalContent $portalContent)
    {
        abort_unless(user_is_admin(), 403);

        $portalContent->update(['is_active' => ! $portalContent->is_active]);

        return back()->with('success', 'تم تغيير الحالة.');
    }

    public function destroy(PortalContent $portalContent)
    {
        abort_unless(user_is_admin(), 403);

        $portalContent->delete();

        return back()->with('success', 'تم الحذف.');
    }
}

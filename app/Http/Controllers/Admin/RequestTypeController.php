<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestTypeController extends Controller
{
    public function index()
    {
        abort_unless(user_is_admin(), 403);
        $types = RequestType::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.request-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        abort_unless(user_is_admin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'code' => 'nullable|string|max:120',
            'requires_time' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $code = Str::slug($data['code'] ?: $data['name'], '_');
        if ($code === '') {
            $code = 'request_'.now()->timestamp;
        }

        RequestType::create([
            'name' => $data['name'],
            'code' => $code,
            'requires_time' => (bool) ($data['requires_time'] ?? false),
            'is_active' => true,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        return back()->with('success', 'تمت إضافة نوع الطلب.');
    }

    public function toggle(RequestType $requestType)
    {
        abort_unless(user_is_admin(), 403);
        $requestType->update(['is_active' => ! $requestType->is_active]);

        return back()->with('success', 'تم تغيير حالة النوع.');
    }

    public function destroy(RequestType $requestType)
    {
        abort_unless(user_is_admin(), 403);
        $requestType->delete();

        return back()->with('success', 'تم حذف نوع الطلب.');
    }
}

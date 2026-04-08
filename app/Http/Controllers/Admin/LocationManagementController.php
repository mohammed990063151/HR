<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeLocation;
use Illuminate\Http\Request;

class LocationManagementController extends Controller
{
    public function index()
    {
        $locations = EmployeeLocation::query()->orderBy('name')->get();

        return view('admin.locations.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meters' => 'required|numeric|min:1',
        ]);

        EmployeeLocation::create($data + ['is_active' => true]);

        return redirect()->route('admin.locations.index')->with('success', 'تم إضافة الموقع.');
    }

    public function update(Request $request, EmployeeLocation $location)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meters' => 'required|numeric|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $location->update($data);

        return redirect()->route('admin.locations.index')->with('success', 'تم تحديث الموقع.');
    }

    public function destroy(EmployeeLocation $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'تم حذف الموقع.');
    }

    public function assignToEmployee(Request $request, Employee $employee)
    {
        $request->validate([
            'location_id' => 'required|exists:employee_locations,id',
        ]);

        $employee->locations()->syncWithoutDetaching([(int) $request->location_id]);

        return back()->with('success', 'تم ربط الموقع بالموظف.');
    }

    public function employeeLocations(Employee $employee)
    {
        return response()->json($employee->locations);
    }

    public function toggle(EmployeeLocation $location)
    {
        $location->update(['is_active' => ! $location->is_active]);

        return back()->with('success', 'تم تغيير حالة الموقع.');
    }
}

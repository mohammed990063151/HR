<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.livewire-admin')]
#[Title('إدخال حضور يدوي')]
class ManualAttendance extends Component
{
    public ?int $user_id = null;

    public string $date = '';

    public ?string $check_in = null;

    public ?string $check_out = null;

    public string $status = 'present';

    public ?string $notes = null;

    public ?int $editing_id = null;

    public function mount(): void
    {
        $this->date = now()->toDateString();
        if (request()->filled('edit')) {
            $row = Attendance::query()->find(request('edit'));
            if ($row) {
                $this->editing_id = $row->id;
                $this->user_id = $row->user_id;
                $this->date = $row->date->format('Y-m-d');
                $this->check_in = $row->check_in?->format('Y-m-d\TH:i');
                $this->check_out = $row->check_out?->format('Y-m-d\TH:i');
                $this->status = $row->status;
                $this->notes = $row->notes;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'status' => 'required|in:present,late,absent',
            'notes' => 'nullable|string|max:2000',
        ], [], [
            'user_id' => 'الموظف',
        ]);

        $user = User::query()->findOrFail($this->user_id);
        $employeePk = Employee::query()->where('employee_id', $user->user_id)->value('id');
        if (! $employeePk) {
            session()->flash('error', 'لا يوجد سجل موظف مرتبط بهذا المستخدم.');

            return;
        }

        $in = $this->check_in ? Carbon::parse($this->check_in) : null;
        $out = $this->check_out ? Carbon::parse($this->check_out) : null;
        $wh = null;
        if ($in && $out) {
            $wh = round($in->diffInMinutes($out) / 60, 2);
        }

        $payload = [
            'user_id' => $user->id,
            'employee_id' => $employeePk,
            'date' => $this->date,
            'check_in' => $in,
            'check_out' => $out,
            'status' => $this->status,
            'working_hours' => $wh,
            'notes' => $this->notes,
            'manually_added' => true,
        ];

        if ($this->editing_id) {
            Attendance::query()->whereKey($this->editing_id)->update(
                collect($payload)->except(['user_id', 'date'])->merge([
                    'user_id' => $user->id,
                    'date' => $this->date,
                ])->toArray()
            );
            session()->flash('success', 'تم تحديث السجل.');
        } else {
            Attendance::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'date' => $this->date,
                ],
                $payload
            );
            session()->flash('success', 'تم حفظ السجل.');
        }

        $this->reset(['check_in', 'check_out', 'notes', 'editing_id']);
        $this->date = now()->toDateString();
        $this->status = 'present';
    }

    public function render()
    {
        return view('livewire.admin.manual-attendance', [
            'employees' => User::query()->where('role', 'employee')->orderBy('name')->get(),
        ]);
    }
}

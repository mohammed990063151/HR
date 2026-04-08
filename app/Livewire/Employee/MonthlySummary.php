<?php

namespace App\Livewire\Employee;

use App\Services\AttendanceService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.livewire-employee')]
#[Title('الملخص الشهري')]
class MonthlySummary extends Component
{
    public int $month = 0;

    public int $year = 0;

    public function mount(): void
    {
        $this->month = (int) now()->month;
        $this->year = (int) now()->year;
    }

    public function render(AttendanceService $svc)
    {
        $start = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $stats = $svc->monthStats((int) auth()->id(), $start, $end);

        return view('livewire.employee.monthly-summary', compact('stats'));
    }
}

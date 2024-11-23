<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class DateHelper
{
    private string $range;
    private Carbon $date;
    /**
     * Create a new class instance.
     */
    public function __construct($range, $date)
    {
        $this->range = $range;
        $this->date = $date;
    }

    function startDate()
    {
        return match ($this->range) {
            'week' => $this->date->copy()->startOfWeek(),
            'month' => $this->date->copy()->startOfMonth(),
            'year' => $this->date->copy()->startOfYear(),
        };
    }

    function endDate()
    {
        return match ($this->range) {
            'week' => $this->date->copy()->endOfWeek(),
            'month' => $this->date->copy()->endOfMonth(),
            'year' => $this->date->copy()->endOfYear(),
        };
    }

    function previousDate()
    {
        return match ($this->range) {
            'week' => $this->date->copy()->subWeek(),
            'month' => $this->date->copy()->subMonth(),
            'year' => $this->date->copy()->subYear(),
        };
    }

    function nextDate()
    {
        return match ($this->range) {
            'week' => $this->date->copy()->addWeek(),
            'month' => $this->date->copy()->addMonth(),
            'year' => $this->date->copy()->addYear(),
        };
    }

    function dateRangeText()
    {
        return match ($this->range) {
            'week' => $this->startDate()->format('M d') . ' - ' . $this->endDate()->format('M d, Y'),
            'month' => $this->date->format('F, Y'),
            'year' => $this->date->format('Y'),
        };
    }

    function paginationDates()
    {
        return Transaction::query()
            ->where('user_id', Auth::user()->id)
            ->select(DB::raw('DATE(date) as date'))
            ->whereBetween('date', [$this->startDate(), $this->endDate()])
            ->orderBy('date', 'desc')
            ->distinct()
            ->pluck('date')
            ->toArray();
    }
}

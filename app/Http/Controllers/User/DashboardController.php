<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use App\Services\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();
        $range = $request->get('range', 'month');

        $dateHelper = new DateHelper($range, $date);
        $startDate = $dateHelper->startDate();
        $endDate = $dateHelper->endDate();

        $previousDate = $dateHelper->previousDate();
        $nextDate = $dateHelper->nextDate();

        $dateRangeText = $dateHelper->dateRangeText();

        $query = Transaction::query()
            ->whereBetween('date', [$startDate, $endDate]);

        $totalIncome = $query->clone()->where('type', 'income')->sum('amount');
        $totalExpense = $query->clone()->where('type', 'expense')->sum('amount') * -1;

        $transactions = $this->groupTransactionsByInterval($query->get(), $range);

        // Calculating summary
        $summary = [
            'total_income' => $totalIncome,
            'total_expense' => abs($totalExpense),
            'net_total' => $totalIncome + $totalExpense,
            'transaction_count' => $query->count(),
            'distribution' => [
                'income_percentage' => $totalIncome + $totalExpense == 0 ? 0 :
                    round(($totalIncome / ($totalIncome + abs($totalExpense))) * 100, 1),
                'expense_percentage' => $totalIncome + $totalExpense == 0 ? 0 :
                    round((abs($totalExpense) / ($totalIncome + abs($totalExpense))) * 100, 1),
            ]
        ];

        return view('user.dashboard', compact(
            'transactions',
            'summary',
            'date',
            'range',
            'previousDate',
            'nextDate',
            'dateRangeText'
        ));
    }

    private function groupTransactionsByInterval($transactions, $range)
    {
        return $transactions->groupBy(function ($item) use ($range) {
            $date = Carbon::parse($item->date);

            return match ($range) {
                'week' => $date->format('D'),
                'month' => $date->format('d M'),
                'year' => $date->format('M'),
                default => $date->format('d M'),
            };
        })->map(function ($group) {
            $income = $group->where('type', 'income')->sum('amount');
            $expense = $group->where('type', 'expense')->sum('amount') * -1;

            return [
                'income' => $income,
                'expense' => abs($expense),
                'total' => $income + $expense
            ];
        })->sortBy(function ($value, $key) {
            return $key;
        });
    }
}

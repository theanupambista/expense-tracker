<?php

namespace App\Http\Controllers\User;

use App\Models\Account;
use App\Models\Transaction;
use App\Services\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->range ?? 'month';
        $date = $request->date ? Carbon::parse($request->date) : now();
        $currentPage = $request->get('page', 1);

        $perPage = 20;

        $dateHelper = new DateHelper($range, $date);
        $dates = $dateHelper->paginationDates();
        $startDate = $dateHelper->startDate();
        $endDate = $dateHelper->endDate();
        $previousDate = $dateHelper->previousDate();
        $nextDate = $dateHelper->nextDate();
        $dateRangeText = $dateHelper->dateRangeText();

        $paginatedDates = new LengthAwarePaginator(
            array_slice($dates, ($currentPage - 1) * $perPage, $perPage),
            count($dates),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Get transactions for the current page dates
        $transactions = Transaction::with(['category', 'account'])
            ->where('user_id', Auth::user()->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereIn(DB::raw('DATE(date)'), $paginatedDates->items())
            ->orderBy('date', direction: 'desc')
            ->get()
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->date)->format('Y-m-d');
            });

        // Calculating summary 
        $summary = Transaction::where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
            ')
            ->first();

        $summary = [
            'income' => $summary->total_income ?? 0,
            'expense' => $summary->total_expense ?? 0,
            'total' => ($summary->total_income ?? 0) - ($summary->total_expense ?? 0)
        ];

        $accounts = Account::all();

        return view('user.transactions.index', compact('date', 'range', 'previousDate', 'nextDate', 'dateRangeText', 'accounts', 'summary', 'transactions', 'paginatedDates'));
    }


    public function store(StoreTransactionRequest $request)
    {
        Transaction::create(attributes: [...$request->validated(), 'user_id' => Auth::user()->id, 'date' => Carbon::now()]);
        return redirect()->route('user.transactions.index')->with('success', 'Transaction added successfully!');
    }

    public function generateReport(Request $request)
    {
        $range = $request->range ?? 'month';
        $date = $request->date ? Carbon::parse($request->date) : now();

        $dateHelper = new DateHelper($range, $date);
        $dateStart = $dateHelper->startDate();
        $dateEnd = $dateHelper->endDate();

        // Get transactions
        $transactions = Transaction::with(['category', 'account'])
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->orderBy('date', 'desc')
            ->get();

        // Calculating summaries
        $summary = [
            'by_category' => $transactions->where('type', 'expense')
                ->groupBy('category.name')
                ->map(fn($group) => $group->sum('amount')),
            'total_income' => $transactions->where('type', 'income')->sum('amount'),
            'total_expense' => $transactions->where('type', 'expense')->sum('amount')
        ];

        $pdf = PDF::loadView('user.transactions.report', [
            'transactions' => $transactions,
            'summary' => $summary,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'range' => $range
        ]);

        return $pdf->download("transactions-{$dateStart->format('Y-m-d')}-to-{$dateEnd->format('Y-m-d')}.pdf");
    }

    public function getExpenseSummary(Request $request)
    {
        $range = $request->range ?? 'month';
        $date = $request->date ? Carbon::parse($request->date) : now();

        $dateHelper = new DateHelper($range, $date);
        $dateStart = $dateHelper->startDate();

        $dateEnd = $dateHelper->endDate();

        $summary = Transaction::whereBetween('date', [$dateStart, $dateEnd])
            ->where('transactions.type', 'expense')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->select(
                'categories.name as category',
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as transaction_count')
            )
            ->groupBy('categories.name')
            ->orderByDesc('total_amount')
            ->get();

        $totalExpense = $summary->sum('total_amount');

        return response()->json([
            'period' => [
                'start' => $dateStart->format('Y-m-d'),
                'end' => $dateEnd->format('Y-m-d'),
                'range' => $range
            ],
            'total_expense' => $totalExpense,
            'by_category' => $summary->map(function ($item) use ($totalExpense) {
                return [
                    'category' => $item->category,
                    'amount' => $item->total_amount,
                    'percentage' => $totalExpense > 0 ? round(($item->total_amount / $totalExpense) * 100, 2) : 0,
                    'transaction_count' => $item->transaction_count
                ];
            })
        ]);
    }

    public function expenseSummary(Request $request)
    {
        $range = $request->range ?? 'month';
        $date = $request->date ? Carbon::parse($request->date) : now();

        $dateHelper = new DateHelper($range, $date);
        $dateStart = $dateHelper->startDate();
        $dateRangeText = $dateHelper->dateRangeText();

        $dateEnd = $dateHelper->endDate();

        $summary = Transaction::whereBetween('date', [$dateStart, $dateEnd])
            ->where('transactions.type', 'expense')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->select(
                'categories.name as category',
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as transaction_count')
            )
            ->groupBy('categories.name')
            ->orderByDesc('total_amount')
            ->get();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $summary]);
        }

        return view('user.transactions.summary', compact('summary', 'date', 'range', 'dateRangeText'));
    }
}

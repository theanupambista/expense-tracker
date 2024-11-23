<!DOCTYPE html>
<html>

<head>
    <title>Transaction Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .transactions-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transactions-table th,
        .transactions-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .transactions-table th {
            background: #f5f5f5;
        }

        .income {
            color: green;
        }

        .expense {
            color: red;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Transaction Report</h1>
        <p>Period: {{ Carbon\Carbon::parse($dateStart)->format('M d, Y') }} -
            {{ Carbon\Carbon::parse($dateEnd)->format('M d, Y') }}</p>
    </div>
    @php
        $currecny = auth()->user()->currency;
    @endphp
    <div class="summary">
        <h2>Summary</h2>
        <table class="summary-table">
            <tr>
                <td>Total Income:</td>
                <td>{{ $currecny }}{{ number_format($summary['total_income'], 2) }}</td>
            </tr>
            <tr>
                <td>Total Expense:</td>
                <td>{{ $currecny }}{{ number_format($summary['total_expense'], 2) }}</td>
            </tr>
            <tr>
                <td>Net:</td>
                <td>{{ $currecny }}{{ number_format($summary['total_income'] - $summary['total_expense'], 2) }}</td>
            </tr>
        </table>

        <h3>Expenses by Category</h3>
        <table class="summary-table">
            @foreach ($summary['by_category'] as $category => $amount)
                <tr>
                    <td>{{ $category }}:</td>
                    <td>{{ $currecny }}{{ number_format($amount, 2) }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <h2>Transactions</h2>
    <table class="transactions-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Account</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td>{{ $transaction->account->name }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td class="{{ $transaction->type }}">
                        {{ $currecny }}{{ number_format($transaction->amount, 2) }}
                    </td>
                    <td>{{ $transaction->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();
        $accounts = Account::all();

        // Get category IDs by type
        $incomeCategories = $categories->where('type', 'income')->pluck('id')->toArray();
        $expenseCategories = $categories->where('type', 'expense')->pluck('id')->toArray();

        $startDate = now()->subMonths(6)->startOfMonth();
        $endDate = now();

        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            // Monthly salary (income) - around 25th of each month
            $salaryDate = $currentDate->copy()->setDay(25);
            if ($salaryDate <= $endDate) {
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'income',
                    'account_id' => $accounts->where('name', 'Saving')->first()->id,
                    'category_id' => $categories->where('name', 'Salary')->first()->id,
                    'amount' => rand(4000, 5000),
                    'note' => 'Monthly salary',
                    'date' => $salaryDate,
                ]);
            }

            // Random additional income (1-2 per month)
            $additionalIncomes = rand(1, 2);
            for ($i = 0; $i < $additionalIncomes; $i++) {
                $randomDay = rand(1, 28);
                $transactionDate = $currentDate->copy()->setDay($randomDay);

                if ($transactionDate <= $endDate) {
                    Transaction::create([
                        'user_id' => $user->id,
                        'type' => 'income',
                        'account_id' => $accounts->random()->id,
                        'category_id' => $categories->whereIn('id', $incomeCategories)
                            ->where('name', '!=', 'Salary')
                            ->random()->id,
                        'amount' => rand(100, 1000),
                        'note' => null,
                        'date' => $transactionDate,
                    ]);
                }
            }

            // Regular monthly expenses
            $monthlyExpenses = [
                ['category' => 'Rent', 'amount' => [1200, 1500], 'day' => 1],
                ['category' => 'Bills', 'amount' => [100, 200], 'day' => rand(10, 15)],
            ];

            foreach ($monthlyExpenses as $expense) {
                $expenseDate = $currentDate->copy()->setDay($expense['day']);
                if ($expenseDate <= $endDate) {
                    Transaction::create([
                        'user_id' => $user->id,
                        'type' => 'expense',
                        'account_id' => $accounts->first()->id,
                        'category_id' => $categories->where('name', $expense['category'])->first()->id,
                        'amount' => rand($expense['amount'][0], $expense['amount'][1]),
                        'note' => "Monthly {$expense['category']}",
                        'date' => $expenseDate,
                    ]);
                }
            }

            // Random daily expenses (2-4 per day)
            $daysInMonth = $currentDate->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $expenseDate = $currentDate->copy()->setDay($day);
                if ($expenseDate <= $endDate) {
                    $dailyExpenses = rand(2, 4);

                    for ($i = 0; $i < $dailyExpenses; $i++) {
                        Transaction::create([
                            'user_id' => $user->id,
                            'type' => 'expense',
                            'account_id' => $accounts->random()->id,
                            'category_id' => $categories->whereIn('id', $expenseCategories)
                                ->whereNotIn('name', ['Rent', 'Bills'])
                                ->random()->id,
                            'amount' => rand(10, 200),
                            'note' => null,
                            'date' => $expenseDate,
                        ]);
                    }
                }
            }

            $currentDate->addMonth();
        }
    }
}

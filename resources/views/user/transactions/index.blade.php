@extends('layouts.app')

@section('title', 'Transaction List')

@section('content')
    @php
        $currency = auth()->user()->currency;
    @endphp
    <div class="py-6" x-data="{
        currentDate: '{{ $date->format('Y-m-d') }}',
        range: '{{ $range }}',
    
        init() {
            this.$watch('currentDate', value => this.updatePage())
            this.$watch('range', value => this.updatePage())
        },
    
        updatePage() {
            window.location.href = `{{ route('user.transactions.index') }}?date=${this.currentDate}&range=${this.range}`
        },
    
        previousPeriod() {
            this.currentDate = '{{ $previousDate->format('Y-m-d') }}';
        },
    
        nextPeriod() {
            this.currentDate = '{{ $nextDate->format('Y-m-d') }}';
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <button @click="previousPeriod" class="p-2 hover:bg-gray-100 rounded-full"
                        {{ $previousDate->isBefore(now()->subYears(5)) ? 'disabled' : '' }}>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <h2 class="text-xl font-semibold">
                        {{ $dateRangeText }}
                    </h2>

                    <button @click="nextPeriod" class="p-2 hover:bg-gray-100 rounded-full"
                        {{ $nextDate->isAfter(now()) ? 'disabled' : '' }}>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>


                <!-- Filters -->
                <div class="flex items-center justify-between">

                    <div class="flex gap-2">
                        @foreach (['week' => 'Weekly', 'month' => 'Monthly', 'year' => 'Yearly'] as $key => $label)
                            <button @click="range = '{{ $key }}'"
                                :class="{
                                    'bg-blue-500 text-white': range === '{{ $key }}',
                                    'bg-gray-100': range !== '{{ $key }}'
                                }"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('user.transactions.report', ['date' => $date->format('Y-m-d'), 'range' => $range]) }}"
                            class="px-4 py-2 bg-green-500 text-white rounded-md text-sm font-medium hover:bg-green-600 transition-colors">
                            Download Report
                        </a>

                        <a href="{{ route('user.transactions.summary', ['date' => $date->format('Y-m-d'), 'range' => $range]) }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                            View Summary
                        </a>
                    </div>
                </div>

            </div>

            <!-- Summary -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-gray-500">Income</h3>
                    <p class="text-2xl font-semibold text-green-600">
                        {{ $currency }}{{ number_format($summary['income'], 2) }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-gray-500">Expense</h3>
                    <p class="text-2xl font-semibold text-red-600">
                        {{ $currency }}{{ number_format($summary['expense'], 2) }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-gray-500">Balance</h3>
                    <p class="text-2xl font-semibold {{ $summary['total'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $currency }}{{ number_format($summary['total'], 2) }}
                    </p>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white rounded-lg shadow divide-y">
                @forelse($transactions as $date => $dayTransactions)
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">
                            {{ Carbon\Carbon::parse($date)->format('M d, l') }}
                        </h3>

                        <div class="space-y-4">
                            @foreach ($dayTransactions as $transaction)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span
                                            class="w-10 h-10 flex items-center rounded-full 
                                        {{ $transaction->type === 'income' ? 'bg-green-500' : 'bg-red-500' }}">
                                            <i data-lucide="{{ $transaction->category->icon }}"
                                                class="w-10 h-10 p-2 text-white"></i>
                                        </span>
                                        <div>
                                            <p class="font-medium">{{ $transaction->category->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $transaction->account->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p
                                            class="font-medium {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}
                                            {{ $currency }}{{ number_format($transaction->amount, 2) }}
                                        </p>
                                        @if ($transaction->note)
                                            <p class="text-sm text-gray-500">{{ $transaction->note }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        No transactions found for this period
                    </div>
                @endforelse

                @if ($paginatedDates->hasPages())
                    <div class="px-6 py-4 border-t">
                        <div class="flex justify-between items-center">
                            @if ($paginatedDates->onFirstPage())
                                <span class="px-4 py-2 text-gray-400 cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $paginatedDates->previousPageUrl() }}&date={{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}&range={{ $range }}"
                                    class="px-4 py-2 text-blue-600 hover:text-blue-800">
                                    Previous
                                </a>
                            @endif

                            <span class="text-gray-600">
                                Page {{ $paginatedDates->currentPage() }} of {{ $paginatedDates->lastPage() }}
                            </span>

                            @if ($paginatedDates->hasMorePages())
                                <a href="{{ $paginatedDates->nextPageUrl() }}&date={{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}&range={{ $range }}"
                                    class="px-4 py-2 text-blue-600 hover:text-blue-800">
                                    Next
                                </a>
                            @else
                                <span class="px-4 py-2 text-gray-400 cursor-not-allowed">
                                    Next
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div @if ($errors->any()) x-data="{ isDrawerOpen: true }"
        @else
        x-data="{ isDrawerOpen: false }" @enderror>
        <div class="fixed bottom-5 right-5">
            <button x-on:click="isDrawerOpen = !isDrawerOpen"
                class="bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-600"
                aria-label="Add">
                +
            </button>
        </div>

        <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
            x-show="isDrawerOpen">
            <div class="fixed inset-0"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                        <div class="pointer-events-auto w-screen max-w-md"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                            <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl"
                                method="POST" action="{{ route('user.transactions.store') }}">
                                @csrf
                                <div class="h-0 flex-1 overflow-y-auto">
                                    <div class="bg-green-600 px-4 py-6 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-base font-semibold leading-6 text-white"
                                                id="slide-over-title">
                                                Add Transaction
                                            </h2>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button type="button" x-on:click="isDrawerOpen=!isDrawerOpen"
                                                    id="close-button"
                                                    class="relative rounded-md bg-green-500 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                    <span class="absolute -inset-2.5"></span>
                                                    <span class="sr-only">Close panel</span>
                                                    <i data-lucide="x" class="text-white w-6 h-6"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between">
                                        <div class="divide-y divide-gray-200 px-4 sm:px-6">
                                            <div class="space-y-6 pb-5 pt-6">
                                                <div>
                                                    <label for="type"
                                                        class="block text-sm font-medium leading-6 text-gray-900">Type</label>
                                                    <select id="type" name="type"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                        <option value="income">Income</option>
                                                        <option value="expense" selected>Expense</option>
                                                    </select>
                                                    @error('type')
                                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="account_id"
                                                        class="block text-sm font-medium leading-6 text-gray-900">Account</label>
                                                    <select id="account_id" name="account_id"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                        required>

                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('account_id')
                                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="category_id"
                                                        class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                                                    <select id="category_id" name="category_id"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    </select>
                                                    @error('category_id')
                                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="amount"
                                                        class="block text-sm font-medium leading-6 text-gray-900">Amount</label>
                                                    <div class="mt-2">
                                                        <input type="number" name="amount" id="amount"
                                                            value="{{ old('amount') }}"
                                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    </div>
                                                    @error('amount')
                                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Optional Note Field -->
                                                <div>
                                                    <label for="note"
                                                        class="block text-sm font-medium leading-6 text-gray-900">Note
                                                        (Optional)</label>
                                                    <textarea name="note" id="note" rows="3"
                                                        class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('note') }}</textarea>
                                                    @error('note')
                                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-shrink-0 justify-end px-4 py-4">
                                    <button type="button" x-on:click="isDrawerOpen = !isDrawerOpen"
                                        id="cancel-button"
                                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</button>
                                    <button type="submit"
                                        class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Fetch categories based on type selection
        function fetchCategories(type) {
            $.ajax({
                url: `/api/categories?type=${type}`, // Your API endpoint to fetch categories
                method: 'GET',
                success: function(data) {
                    $('#category_id').empty(); // Clear the current category options
                    data.forEach(function(category) {
                        $('#category_id').append(new Option(category.name, category.id));
                    });
                },
                error: function(error) {
                    console.error('Error fetching categories:', error);
                }
            });
        }

        // On page load, fetch categories for the default type 'expense'
        fetchCategories('expense');

        // When the type is changed, fetch categories accordingly
        $('#type').change(function() {
            var type = $(this).val(); // Get the selected type
            fetchCategories(type); // Fetch the corresponding categories
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')


@section('content')
    @php
        $currency = auth()->user()->currency;
    @endphp
    <div x-data="{
        currentDate: '{{ $date->format('Y-m-d') }}',
        range: '{{ $range }}',
        chartData: {{ json_encode($transactions) }},
        summary: {{ json_encode($summary) }},
    
        init() {
            this.$watch('currentDate', value => this.updatePage())
            this.$watch('range', value => this.updatePage())
            this.initializeCharts()
        },
    
        updatePage() {
            window.location.href = `{{ route('user.dashboard') }}?date=${this.currentDate}&range=${this.range}`
        },
    
        previousPeriod() {
            this.currentDate = '{{ $previousDate->format('Y-m-d') }}'
        },
    
        nextPeriod() {
            this.currentDate = '{{ $nextDate->format('Y-m-d') }}'
        },
    
        initializeCharts() {
            this.createBarChart()
            this.createLineChart()
            this.createPieChart()
        },
    
        createBarChart() {
            const ctx = document.getElementById('barChart').getContext('2d')
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(this.chartData),
                    datasets: [{
                            label: 'Income',
                            data: Object.values(this.chartData).map(item => item.income),
                            backgroundColor: '#10B981',
                        },
                        {
                            label: 'Expense',
                            data: Object.values(this.chartData).map(item => item.expense),
                            backgroundColor: '#EF4444',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            })
        },
    
        createLineChart() {
            const ctx = document.getElementById('lineChart').getContext('2d')
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(this.chartData),
                    datasets: [{
                        label: 'Net Total',
                        data: Object.values(this.chartData).map(item => item.total),
                        borderColor: '#6366F1',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true
                }
            })
        },
    
        createPieChart() {
            const ctx = document.getElementById('pieChart').getContext('2d')
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Income', 'Expense'],
                    datasets: [{
                        data: [
                            this.summary.distribution.income_percentage,
                            this.summary.distribution.expense_percentage
                        ],
                        backgroundColor: ['#10B981', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw}%`;
                                }
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            })
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

                <!--  Filters -->
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
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Total Income</div>
                    <div class="text-2xl font-semibold text-green-600">
                        {{ $currency }}{{ number_format($summary['total_income'], 2) }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Total Expense</div>
                    <div class="text-2xl font-semibold text-red-600">
                        {{ $currency }}{{ number_format($summary['total_expense'], 2) }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Net Total</div>
                    <div class="text-2xl font-semibold" :class="summary.net_total >= 0 ? 'text-green-600' : 'text-red-600'">
                        {{ $currency }}{{ number_format($summary['net_total'], 2) }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Transactions</div>
                    <div class="text-2xl font-semibold text-blue-600">
                        {{ number_format($summary['transaction_count']) }}
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Income vs Expense</h3>
                    <canvas id="barChart"></canvas>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Net Total Trend</h3>
                    <canvas id="lineChart"></canvas>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Income/Expense Distribution</h3>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

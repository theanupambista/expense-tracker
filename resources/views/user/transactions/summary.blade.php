@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold mb-6">Expense Summary</h2>
                    <h2 class="text-xl font-semibold mb-6">{{ $dateRangeText }}</h2>
                </div>

                <div class="grid gap-6">
                    @php
                        $currency = auth()->user()->currency;
                    @endphp
                    @foreach ($summary as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium">{{ $item->category }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $item->transaction_count }} transactions
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-red-600">
                                    {{ $currency }}{{ number_format($item->total_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('header', 'Admin Dashboard')


@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Total Users</div>
                    <div class="text-2xl font-semibold text-green-600">
                        {{ $totalUsers }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Total Categories</div>
                    <div class="text-2xl font-semibold text-red-600">
                        {{ $totalCategories }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-600">Total Transactions</div>
                    <div class="text-2xl font-semibold">
                        {{ $totalTransactions }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

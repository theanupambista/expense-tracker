@extends('layouts.app')

@section('title', 'Categories')


@section('header', 'Categories')

@section('content')
    <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
        <div class="flex">
            <h3 class="text-md font-semibold text-gray-800 ">
                Income Categories
            </h3>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4">
            @foreach ($incomes as $income)
                <div class="max-w-md">
                    <div class="bg-white rounded-lg shadow-md p-4 flex justify-between items-center">

                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i data-lucide="{{ $income->icon }}" class="text-blue-600 w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $income->name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg mt-4">
        <div class="flex">
            <h3 class="text-md font-semibold text-gray-800 ">
                Expense Categories
            </h3>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4">
            @foreach ($expenses as $expense)
                <div class="max-w-md">
                    <div class="bg-white rounded-lg shadow-md p-4 flex justify-between items-center">

                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i data-lucide="{{ $expense->icon }}" class="text-blue-600 w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $expense->name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

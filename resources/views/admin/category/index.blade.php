@extends('layouts.app')

@section('title', 'Categories')

@section('styles')
    <style>
        .icon-item.selected {
            border: 2px solid #007bff;
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection

@section('header', 'Categories')

@section('content')
    <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg"
        @if ($errors->any()) x-data="{ isDrawerOpen: true }"
    @else
    x-data="{ isDrawerOpen: false }" @enderror>
    @if (session('success'))
                <div class="flex justify-between items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded mb-4" id="success-alert" role="alert">
                    <p>{{ session('success') }}</p>
                    <p><i data-lucide="x" class="h-6 w-6 text-white cursor-pointer" onclick="closeSuccess()"></i></p>
                </div> @endif
        <div class="flex flex-row-reverse">
        <button type="button" x-on:click="isDrawerOpen = !isDrawerOpen"
            class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Add Category
            <i data-lucide="plus"></i>
            </svg>
        </button>

    </div>
    <h3 class="text-md text-gray-800 font-semibold">Income Categories</h3>
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
                    <div class="relative" x-data="{ isOpen: false }">
                        <button x-on:click="isOpen=!isOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i data-lucide="ellipsis" class="text-blue-600 w-6 h-6"></i>
                        </button>
                        <div x-show="isOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('admin.categories.edit', ['category' => $income->id]) }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                <i data-lucide="pencil" class="h-4 w-4 mr-2"></i>
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.categories.destroy', $income->id) }}"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" x-on:click="isOpen=!isOpen "
                                    class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 w-full text-left show_confirm"
                                    data-toggle="tooltip" title='Delete'><i data-lucide="trash"
                                        class="w-4 h-4 mr-2"></i>Delete</button>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- drawer --}}
    <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" x-show="isDrawerOpen">
        <div class="fixed inset-0"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                    <div class="pointer-events-auto w-screen max-w-md"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                        <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl" method="POST"
                            action="{{ route('admin.categories.store') }}">
                            @csrf
                            <div class="h-0 flex-1 overflow-y-auto">
                                <div class="bg-green-600 px-4 py-6 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                            Add Category</h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button type="button" x-on:click="isDrawerOpen=!isDrawerOpen"
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
                                            </div>
                                            <div>
                                                <label for="name"
                                                    class="block text-sm font-medium leading-6 text-gray-900">
                                                    Name</label>
                                                <div class="mt-2">
                                                    <input type="text" name="name" id="name"
                                                        value="{{ old('name') }}"
                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                </div>
                                                @error('name')
                                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="icon"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Icon</label>
                                                <div id="icon-container"
                                                    class="flex flex-row gap-3 space-x-2 mt-2 flex-wrap items-center">
                                                </div>
                                                @error('icon')
                                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                                @enderror
                                                <input type="hidden" id="selected-icon" name="icon"
                                                    value="{{ old('icon') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 justify-end px-4 py-4">
                                <button type="button" x-on:click="isDrawerOpen = !isDrawerOpen"
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

    <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg mt-4">
        <h3 class="text-md text-gray-800 font-semibold">Expense Categories</h3>
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
                        <div class="relative" x-data="{ isOpen: false }">
                            <button x-on:click="isOpen=!isOpen"
                                class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i data-lucide="ellipsis" class="text-blue-600 w-6 h-6"></i>
                            </button>
                            <div x-show="isOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="{{ route('admin.categories.edit', ['category' => $expense->id]) }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                    <i data-lucide="pencil" class="h-4 w-4 mr-2"></i>
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.categories.destroy', $expense->id) }}"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" x-on:click="isOpen=!isOpen "
                                        class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 w-full text-left show_confirm"
                                        data-toggle="tooltip" title='Delete'><i data-lucide="trash"
                                            class="w-4 h-4 mr-2"></i>Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Array of icons to display
        const icons = ['wallet', 'house', 'hand-coins', 'refresh-ccw', 'utensils', 'heart-pulse', 'school', 'shirt',
            'clapperboard', 'bus', 'receipt', 'bookmark-check'
        ];

        // Get the container where icons will be rendered
        const container = $('#icon-container');

        // Loop through the icons array to create clickable icon elements
        icons.forEach(iconName => {
            const selectedIcon = $('#selected-icon').val();
            // Create a div for each icon
            const iconDiv = $(
                '<div class="bg-gray-200 text-gray-800 items-center justify-center w-10 h-10 rounded cursor-pointer flex icon-item"></div>'
            );

            // Create an SVG element for the Lucide icon
            const svgElement = $('<svg></svg>')
                .attr('data-lucide', iconName)
                .addClass('w-6 h-6 cursor-pointer');

            // Append the icon SVG to the div
            iconDiv.append(svgElement);

            // Append the div to the container
            container.append(iconDiv);


            if (iconName === selectedIcon) {
                iconDiv.addClass('selected');
            }
        });

        // Initialize Lucide icons
        lucide.createIcons();

        // Icon selection functionality
        $(document).on('click', '.icon-item', function() {
            // Remove the "selected" class from all icon items
            $('.icon-item').removeClass('selected');

            // Add the "selected" class to the clicked icon
            $(this).addClass('selected');

            // Get the selected icon name and set it in the hidden input field
            const selectedIcon = $(this).find('svg').attr('data-lucide');
            $('#selected-icon').val(selectedIcon);
        });

        function closeSuccess() {
            $('#success-alert').css('display', 'none');
        }
    </script>
@endsection

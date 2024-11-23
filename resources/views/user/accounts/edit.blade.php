@extends('layouts.app')

@section('title', 'Edit Accounts')

@section('styles')
    <style>
        .icon-item.selected {
            border: 2px solid #007bff;
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection

@section('header', 'Edit Account')

@section('content')
    <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
        <form class="flex h-full flex-col" method="POST"
            action="{{ route('user.accounts.update', ['account' => $account->id]) }}">
            @csrf
            @method('PUT')
            <div class="h-0 flex-1 overflow-y-auto">
                <div class="flex flex-1 flex-col justify-between">
                    <div class="divide-y divide-gray-200 px-4 sm:px-6">
                        <div class="space-y-6 pb-5 pt-6">
                            <div>
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                                    Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ $account->name }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('name')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>


                            <div>
                                <label for="icon" class="block text-sm font-medium leading-6 text-gray-900">Icon</label>
                                <div id="icon-container" class="flex flex-row space-x-4 mt-2"></div>
                                @error('icon')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                                <input type="hidden" id="selected-icon" name="icon" value="{{ $account->icon }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-shrink-0 justify-end px-4 py-4">
                <a type="button" href="{{ route('user.accounts.index') }}"
                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit"
                    class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        // Array of icons to display
        const icons = ['landmark', 'credit-card', 'banknote', 'piggy-bank'];

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
    </script>
@endsection

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name', 'Expense Tracker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @yield('styles')
</head>

<body class="h-full">
    @include('sweetalert::alert')
    <div class="min-h-full">
        <div class="bg-indigo-600 pb-32">
            <nav x-data="{ isMobileMenuOpen: false }"
                class="border-b border-indigo-300 border-opacity-25 bg-indigo-600 lg:border-none">
                <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
                    <div
                        class="relative flex h-16 items-center justify-between lg:border-b lg:border-indigo-400 lg:border-opacity-25">
                        <div class="flex items-center px-2 lg:px-0">
                            <div class="flex-shrink-0">
                                <h2 class="text-2xl text-white font-semibold">Expense Tracker</h2>
                            </div>
                            @if (auth()->user()->role === 'user')
                                @include('layouts.menu.user-menu')
                            @elseif(auth()->user()->role === 'admin')
                                @include('layouts.menu.admin-menu')
                            @endif
                        </div>

                        <div class="flex lg:hidden">
                            <!-- Mobile menu button -->
                            <button type="button" @click="isMobileMenuOpen = !isMobileMenuOpen"
                                class="relative inline-flex items-center justify-center rounded-md bg-indigo-600 p-2 text-indigo-200 hover:bg-indigo-500 hover:bg-opacity-75 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
                                aria-controls="mobile-menu" aria-expanded="false">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                                <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="hidden lg:ml-4 lg:block">
                            <div class="flex items-center">
                                <div x-data="{ isOpen: false }" class="relative ml-3 flex-shrink-0">
                                    <div>
                                        <button type="button" @click="isOpen = !isOpen"
                                            class="relative flex rounded-full  border-2 border-white bg-indigo-600 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
                                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="absolute -inset-1.5"></span>
                                            <span class="sr-only">Open user menu</span>
                                            <i class="h-8 w-8 rounded-full p-2" data-lucide="user"></i>

                                        </button>
                                    </div>

                                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75 transform"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                        tabindex="-1">
                                        <!-- Active: "bg-gray-100", Not Active: "" -->
                                        <a href="{{ route('profile.edit') }}"
                                            class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                            id="user-menu-item-0">Your Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                                tabindex="-1" id="user-menu-item-2"
                                                onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->role === 'user')
                    @include('layouts.menu.user-mobile-menu')
                @elseif(auth()->user()->role === 'admin')
                    @include('layouts.menu.user-mobile-menu')
                @endif
            </nav>
            <header class="py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-white">@yield('header')</h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                {{-- <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6"> --}}
                @yield('content')
                {{-- </div> --}}
            </div>
        </main>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.show_confirm').click(function(event) {
                var form = $(this).closest("form");
                event.preventDefault(); // Prevent form submission

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>

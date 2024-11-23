<div class="lg:hidden" x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-100 transform"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75 transform" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95" id="mobile-menu">
    <div class="space-y-1 px-2 pb-3 pt-2">
        <a href="{{ route('admin.dashboard') }}"
            class="text-white block rounded-md py-2 px-3 text-base font-medium  {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}"
            aria-current="page">Dashboard</a>
        <a href="{{ route('admin.categories.index') }}"
            class="text-white block rounded-md py-2 px-3 text-base font-medium  {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Categories</a>
    </div>
    <div class="border-t border-indigo-700 pb-3 pt-4">
        <div class="flex items-center px-5">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="">
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                <div class="text-sm font-medium text-indigo-300">{{ auth()->user()->email }}</div>
            </div>
            <button type="button"
                class="relative ml-auto flex-shrink-0 rounded-full bg-indigo-600 p-1 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">View notifications</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </button>
        </div>
        <div class="mt-3 space-y-1 px-2">
            <a href="{{ route('profile.edit') }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75">Your
                Profile</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75">Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                    class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
        </div>
    </div>
</div>

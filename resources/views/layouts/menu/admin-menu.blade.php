<div class="hidden lg:ml-10 lg:block">
    <div class="flex space-x-4">
        <a href="{{ route('admin.dashboard') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}"
            aria-current="page">Dashboard</a>
        <a href="{{ route('admin.categories.index') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Categories</a>
    </div>
</div>

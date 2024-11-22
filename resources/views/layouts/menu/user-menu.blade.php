<div class="hidden lg:ml-10 lg:block">
    <div class="flex space-x-4">
        <a href="{{ route('user.dashboard') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}"
            aria-current="page">Dashboard</a>
        <a href="#"
            class="text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium">Analysis</a>
        <a href="#"
            class="text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium">Budgets</a>
        <a href="{{ route('user.accounts.index') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('user.accounts.*') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Accounts</a>
        <a href="#"
            class="text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium">Categories</a>
    </div>
</div>

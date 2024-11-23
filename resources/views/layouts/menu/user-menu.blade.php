<div class="hidden lg:ml-10 lg:block">
    <div class="flex space-x-4">
        <a href="{{ route('user.dashboard') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Dashboard</a>
        <a href="{{ route('user.transactions.index') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('user.transactions.*') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Transactions</a>
        <a href="{{ route('user.accounts.index') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('user.accounts.*') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Accounts</a>
        <a href="{{ route('user.categories.index') }}"
            class="text-white rounded-md py-2 px-3 text-sm font-medium {{ request()->routeIs('user.categories.index') ? 'bg-indigo-700' : 'hover:bg-indigo-500 hover:bg-opacity-75' }}">Categories</a>

    </div>
</div>

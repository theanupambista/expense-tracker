@extends('layouts.guest')

@section('content')
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-xl font-bold">ExpenseTracker</div>
                @auth

                    @if (Auth::user()->role === 'user')
                        <a href="{{ route('user.dashboard') }}"
                            class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition">
                            User Dashboard
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition">
                            Admin Dashboard
                        </a>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('register') }}"
                        class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition">
                        Sign Up Free
                    </a>
                @endguest


            </div>
        </nav>
        <div class="container mx-auto px-6 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Track Your Expenses Effortlessly</h1>
                <p class="text-xl mb-8">Take control of your finances with our powerful and user-friendly Expense
                    Tracker.</p>
                @auth

                    @if (Auth::user()->role === 'user')
                        <a href="{{ route('user.dashboard') }}"
                            class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition">
                            User Dashboard
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition">
                            Admin Dashboard
                        </a>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('register') }}"
                        class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-50 transition">
                        Sign Up Free
                    </a>
                @endguest
            </div>
        </div>
    </header>

    <!-- Why Choose Us Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Why Choose Us?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Simple & Intuitive</h3>
                    <p class="text-gray-600">Easily record your daily expenses with a clean and user-friendly interface.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Comprehensive Insights</h3>
                    <p class="text-gray-600">Get detailed summaries of your expenses by week, month, or year.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Secure & Private</h3>
                    <p class="text-gray-600">Your data is protected with the highest security standards.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Features You'll Love</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-2xl mb-4">📈</div>
                    <h3 class="font-semibold mb-2">Expense Summaries</h3>
                    <p class="text-gray-600">Visualize your expenses with clear and interactive graphs.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-2xl mb-4">📊</div>
                    <h3 class="font-semibold mb-2">API Access</h3>
                    <p class="text-gray-600">Access your expense summaries programmatically via our API.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-2xl mb-4">👨‍💻</div>
                    <h3 class="font-semibold mb-2">Admin Dashboard</h3>
                    <p class="text-gray-600">Manage users and monitor platform activities.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-2xl mb-4">🛡️</div>
                    <h3 class="font-semibold mb-2">Secure Authentication</h3>
                    <p class="text-gray-600">Multi-role authentication for added flexibility.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">
                        1</div>
                    <h3 class="font-semibold mb-2">Sign Up</h3>
                    <p class="text-gray-600">Create an account in seconds</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">
                        2</div>
                    <h3 class="font-semibold mb-2">Log Expenses</h3>
                    <p class="text-gray-600">Quickly add your daily expenses</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">
                        3</div>
                    <h3 class="font-semibold mb-2">Analyze Data</h3>
                    <p class="text-gray-600">Get clear insights into spending</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">
                        4</div>
                    <h3 class="font-semibold mb-2">Achieve Goals</h3>
                    <p class="text-gray-600">Plan for a better future</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-8">Start Tracking Your Expenses Today</h2>
            <p class="text-xl mb-8">Join thousands of users who are managing their finances smarter.</p>
            <a href="{{ route('register') }}"
                class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-blue-50 transition">
                Sign Up for Free
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2024 ExpenseTracker. All rights reserved.</p>
        </div>
    </footer>
@endsection

<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalCategories = Category::count();
        return view('admin.dashboard', compact('totalUsers', 'totalTransactions', 'totalCategories'));
    }
}

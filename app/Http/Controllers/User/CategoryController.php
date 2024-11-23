<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories['incomes'] = Category::where('type', 'income')->get();
        $categories['expenses'] = Category::where('type', 'expense')->get();

        return view('user.categories.index', $categories);
    }
}

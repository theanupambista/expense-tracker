<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Transaction;

class CategoryController extends Controller
{

    public function index()
    {
        $categories['incomes'] = Category::where('type', 'income')->get();
        $categories['expenses'] = Category::where('type', 'expense')->get();

        return view('admin.category.index', $categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create(attributes: $request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
    }


    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }


    public function destroy(Category $category)
    {
        if (Transaction::where('category_id', $category->id)->count() > 0) {
            return redirect()->route('admin.categories.index')->with('success', "Category cannot be deleted!");
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', "Category deleted successfully!");
    }
}

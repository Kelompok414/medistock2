<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $search = $request->input('search');

        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->paginate(10); // This enables pagination

        return view('category.index', compact('categories'));
    }


    public function create()
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('category.create');
    }

    public function store(Request $request)
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $request->validate(['name' => 'required|unique:categories']);

        Category::create($request->only('name'));
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}

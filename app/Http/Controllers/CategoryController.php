<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('project')->latest()->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with(['documentations', 'project'])->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function consulterLesCategories()
    {
        return $this->index();
    }
}

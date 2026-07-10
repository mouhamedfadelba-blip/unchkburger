<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;

class HomeController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = $this->categoryService->getActiveCategoriesWithBurgers();
        return view('welcome', compact('categories'));
    }
}

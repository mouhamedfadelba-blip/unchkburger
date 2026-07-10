<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;

class CatalogueController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getActiveCategoriesWithBurgers();
        return view('customer.catalogues.index', compact('categories'));
    }
}

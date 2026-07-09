<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getActiveCategoriesWithBurgers(): Collection
    {
        return Category::with(['burgers' => function($query) {
            $query->where('stock', '>', 0)
                ->where('is_archived','=','false');
        }])->get();
    }
}

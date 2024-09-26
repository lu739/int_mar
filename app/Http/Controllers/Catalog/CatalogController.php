<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $categories = Category::query()
            ->has('products')
            ->get();

        $brands = Brand::query()
            ->has('products')
            ->get();

        $products = Product::query()
            ->when($category->exists(), function (Builder $query) use ($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id
                );
            })
            ->filtered()
            ->sorted()
            ->paginate(6);

        return view('catalog.index',
            compact('products', 'categories', 'category', 'brands')
        );
    }
}

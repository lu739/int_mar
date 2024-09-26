<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $brands = Brand::query()->homePage()->get();
        $categories = Category::query()->homePage()->get();
        $products = Product::query()->homePage()->get();

        return view('welcome', compact('brands', 'categories', 'products'));
    }
}

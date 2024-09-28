<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $viewedProductIds = [];
        if (session()->has('viewed.products')) {
            $viewedProductIds = session()->get('viewed.products');
        }

        // Получаем ключи массива
        $keys = array_keys($viewedProductIds);

        if (count($keys) > 5) {
            // Обрезаем ключи до последних 5 элементов
            $keys = array_slice($keys, -5);
        }

        // Создаем новый массив с сохранением ключей
        $viewedProductIds = array_intersect_key($viewedProductIds, array_flip($keys));

        // Добавляем новый просмотренный продукт
        $viewedProductIds[$product->id] = $product->id;

        session()->put('viewed.products', $viewedProductIds);

        $viewedProducts = Product::query()
            ->where(function (Builder $query) use ($viewedProductIds, $product) {
                $query
                    ->whereIn('id', $viewedProductIds)
                    ->whereNot('id', $product->id);
            })
            ->get();

        return view('product.show', compact('product', 'viewedProducts'));
    }
}

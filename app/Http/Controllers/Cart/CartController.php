<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;

class CartController extends Controller
{
    public function index(): View|Application|Factory
    {
        $cartItems = cart()->getCartItems();

        return view('cart.index', compact('cartItems'));
    }

    public function add(Product $product): RedirectResponse
    {
        cart()->add($product, request('quantity', 1));

        flash()->info('Товар добавлен в корзину');

        return redirect()->intended(route('cart'));
    }
    public function quantity(CartItem $cartItem): RedirectResponse
    {
        $quantityDiff = (int)request('quantity');
        if (request('new_total_quantity')) {
            $quantityDiff = (int)request('new_total_quantity') - $cartItem->quantity;
        }

        cart()->quantity($cartItem, $quantityDiff);

        flash()->info('Количество товаров изменено');

        return redirect()->intended(route('cart'));
    }

    public function delete(CartItem $cartItem): RedirectResponse
    {
        cart()->delete($cartItem);

        flash()->info('Товар удален из корзины');

        return redirect()->intended(route('cart'));
    }
    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()->intended(route('cart'));
    }
}

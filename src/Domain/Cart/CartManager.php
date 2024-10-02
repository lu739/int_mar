<?php

namespace Domain\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\StorageIdentities\FakeIdentityStorage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(protected CartIdentityStorageContract $cartIdentityStorage)
    {
    }

    public static function fake(): void
    {
        app()->bind(CartIdentityStorageContract::class, FakeIdentityStorage::class);
    }
    private function cacheKey(): string
    {
        return str('cart_' . $this->cartIdentityStorage->get())
            ->slug()
            ->value();
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }
    private function storageData(string $storageId): array
    {
        $data = [
            'storage_id' => $storageId
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    public function updateStorageId(string $old, string $new): void
    {
        Cart::query()
            ->where('storage_id', $old)
            ->update($this->storageData($new));
    }

    public function add(Product $product, int $quantity = 1): Cart
    {
        $cart = Cart::query()->updateOrCreate([
            'storage_id' => $this->cartIdentityStorage->get(),
        ], $this->storageData($this->cartIdentityStorage->get()));

        if (!app()->environment('testing')) {
            $existingCartItem = $cart->cartItems()->where('product_id', $product->id)->first();

            if ($existingCartItem) {
                $existingCartItem->update([
                    'quantity' => DB::raw("quantity + $quantity"),
                    'price' => $product->price,
                ]);
            } else {
                $cart->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'cart_id' => $cart->id,
                ]);
            }
        } else {
            // dd('testing', $quantity);
            $cart->cartItems()->updateOrCreate([
                'product_id' => $product->id,
            ], [
                'quantity' => $quantity,
                'price' => $product->price,
                'cart_id' => $cart->id,
            ]);
        }


        $this->forgetCache();

        return $cart;
    }

    public function quantity(CartItem $cartItem, int $quantity): void
    {
        if ($cartItem->quantity <= -$quantity) {
            $this->delete($cartItem);
            return;
        }

        $cartItem->update([
            'quantity' => DB::raw("quantity + $quantity")
        ]);

        $this->forgetCache();
    }

    public function delete(CartItem $cartItem): void
    {
        $cartItem->delete();

        $this->forgetCache();
    }

    public function truncate(): void
    {
        if (!$this->get()) {
            return;
        }

        $this->get()->delete();

        $this->forgetCache();
    }

    public function get(): mixed
    {
        return Cache::remember(
            $this->cacheKey(),
            now()->addHour(),
            function () {
                return Cart::query()
                    ->with('cartItems')
                    ->where('storage_id', $this->cartIdentityStorage->get())
                    ->when(auth()->check(), fn($query) => $query->orWhere('user_id', auth()->id()))
                    ->first() ?? false;
            }
        );
    }

    public function getCartItems(): Collection
    {
        if (!$this->get()) {
            return collect([]);
        }
        return $this->get()->cartItems()->with('product')->get();
    }

    public function count(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    public function total(): Price
    {
        return new Price($this->getCartItems()
            ->sum(fn (CartItem $cartItem) =>
            $cartItem->amount->raw()
            )
        );
    }

    public function amount(CartItem $cartItem): Price
    {
        return new Price($this->getCartItems()
            ->where('product_id', $cartItem->product_id)
            ->sum(fn (CartItem $cartItem) =>
                $cartItem->amount->raw()
            )
        );
    }
}

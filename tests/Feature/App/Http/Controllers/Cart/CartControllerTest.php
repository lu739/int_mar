<?php

namespace Tests\Feature\App\Http\Controllers\Cart;

use App\Http\Controllers\Cart\CartController;
use App\Models\Cart;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public Collection $products;
    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();

        $this->products = ProductFactory::new()->count(10)->create();
    }

    public function test_is_cart_empty()
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('cartItems', collect([]));
    }

    public function test_is_cart_not_empty()
    {
        foreach ($this->products as $product) {
            cart()->add($product, 1);
        }

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('cartItems', cart()->getCartItems());
    }

    public function test_is_product_add_to_cart()
    {
        $this->assertEquals(cart()->count(), 0);

        $this->post(action([CartController::class, 'add'], $this->products->first()), [
            'quantity' => 2
        ]);
        $this->post(action([CartController::class, 'add'], $this->products->last()), [
            'quantity' => 3
        ]);

        $this->assertEquals(cart()->count(), 5);
    }
    public function test_is_product_quantity_changed()
    {
        cart()->add($this->products->first());
        $this->assertEquals(cart()->count(), 1);

        $this->post(action([CartController::class, 'quantity'], cart()->getCartItems()->first()), [
            'quantity' => 2
        ]);

        $this->assertEquals(cart()->count(), 3);
    }
    public function test_is_product_deleted()
    {
        cart()->add($this->products->last(), 5);
        $this->assertEquals(cart()->count(), 5);

        $this->delete(action([CartController::class, 'delete'], cart()->getCartItems()->first()));

        $this->assertEquals(cart()->count(), 0);
    }
    public function test_is_cart_truncated()
    {
        cart()->add($this->products->first(), 2);
        cart()->add($this->products->last(), 3);

        $this->assertEquals(cart()->count(), 5);
        $this->assertNotFalse(cart()->get());

        $this->delete(action([CartController::class, 'truncate']));

        $this->assertFalse(cart()->get());
    }
}

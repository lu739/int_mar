<?php

namespace Domain\Order\Processes;

use App\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;

class DecreaseProductQuantyties implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->getCartItems() as $item) {
            $item->product->update([
                'quantity' => $item->product->quantity - $item->quantity
            ]);
        }
        return $next($order);
    }
}

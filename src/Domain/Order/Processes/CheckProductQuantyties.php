<?php

namespace Domain\Order\Processes;

use App\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;

class CheckProductQuantyties implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->getCartItems() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new OrderProcessException('Недостаточно товара');
            }
        }

        return $next($order);
    }
}

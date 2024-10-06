<?php

namespace Domain\Order\Processes;

use App\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;

class AssignProducts implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $order->orderItems()
            ->createMany(cart()->getCartItems()->map(function ($item) {
            return [
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        }
        )->toArray());

        return $next($order);
    }
}

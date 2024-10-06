<?php

namespace Domain\Order\Processes;

use App\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;

class ClearCart implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        cart()->truncate();

        return $next($order);
    }
}

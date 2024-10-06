<?php

namespace Domain\Order\Contracts;

use App\Models\Order;

interface OrderProcessContract
{
    public function handle(Order $order, $next);
}

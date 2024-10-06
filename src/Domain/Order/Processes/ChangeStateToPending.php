<?php

namespace Domain\Order\Processes;

use App\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\States\PendingOrderState;

class ChangeStateToPending implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $order->status->transitionTo(new PendingOrderState($order));

        return $next($order);
    }
}

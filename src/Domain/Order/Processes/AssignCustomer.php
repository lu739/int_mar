<?php

namespace Domain\Order\Processes;

use App\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;

class AssignCustomer implements OrderProcessContract
{

    public function __construct(protected array $customer)
    {
    }

    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create(collect($this->customer)->only(['first_name', 'last_name'])->toArray());

        return $next($order);
    }
}

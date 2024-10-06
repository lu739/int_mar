<?php

namespace Domain\Order\States;

use App\Models\Order;
use Domain\Order\Events\OrderStatusChanged;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [

    ];

    public function __construct(protected Order $order)
    {
    }

    abstract public function canBeChanged(): bool;
    abstract public function value(): string;
    abstract public function humanValue(): string;

    public function transitionTo(OrderState $state): void
    {
        if (!$this->canBeChanged()) {
            throw new InvalidArgumentException('Нельзя поменять статус');
        }

        if (!in_array(get_class($state), $this->allowedTransitions)) {
            throw new InvalidArgumentException('Нельзя поменять статус с ' . $this->order->status->value() . ' на ' . $state->value());
        }

        $this->order->updateQuietly([
            'status' => $state->value()
        ]);

        event(new OrderStatusChanged(
            $this->order,
            $this->order->status,
            $state,
        ));
    }
}

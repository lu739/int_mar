<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatusEnum;

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendingOrderState::class,
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatusEnum::NEW->value;
    }

    public function humanValue(): string
    {
        return OrderStatusEnum::NEW->description();
    }
}

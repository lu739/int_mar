<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatusEnum;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatusEnum::PENDING->value;
    }

    public function humanValue(): string
    {
        return OrderStatusEnum::PENDING->description();
    }
}

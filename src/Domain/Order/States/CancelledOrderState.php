<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatusEnum;

class CancelledOrderState extends OrderState
{
    protected array $allowedTransitions = [

    ];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return OrderStatusEnum::CANCELLED->value;
    }

    public function humanValue(): string
    {
        return OrderStatusEnum::CANCELLED->description();
    }
}

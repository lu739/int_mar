<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatusEnum;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatusEnum::PAID->value;
    }

    public function humanValue(): string
    {
        return OrderStatusEnum::PAID->description();
    }
}

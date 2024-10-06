<?php

namespace Domain\Order\Enums;

use App\Models\Order;
use Domain\Order\States\CancelledOrderState;
use Domain\Order\States\NewOrderState;
use Domain\Order\States\OrderState;
use Domain\Order\States\PaidOrderState;
use Domain\Order\States\PendingOrderState;

enum OrderStatusEnum: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function description(): string
    {
        return match ($this) {
            self::NEW => 'Новый',
            self::PENDING => 'В обработке',
            self::PAID => 'Оплачен',
            self::CANCELLED => 'Отменен',
        };
    }

    public function createState(Order $order): OrderState
    {
        return match ($this) {
            self::NEW => new NewOrderState($order),
            self::PENDING => new PendingOrderState($order),
            self::PAID => new PaidOrderState($order),
            self::CANCELLED => new CancelledOrderState($order),
        };
    }
}

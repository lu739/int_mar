<?php

namespace Domain\Order\States\Payment;

use Spatie\ModelStates\StateConfig;

class PendingPaymentState extends PaymentState
{
    public function name(): string
    {
        return 'pending';
    }
}

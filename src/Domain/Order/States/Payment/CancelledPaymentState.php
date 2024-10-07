<?php

namespace Domain\Order\States\Payment;

use Spatie\ModelStates\StateConfig;

class CancelledPaymentState extends PaymentState
{
    public function name(): string
    {
        return 'failed';
    }
}

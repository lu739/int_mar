<?php

namespace Domain\Order\States\Payment;

use Spatie\ModelStates\StateConfig;

class PaidPaymentState extends PaymentState
{
    public function name(): string
    {
        return 'paid';
    }
}

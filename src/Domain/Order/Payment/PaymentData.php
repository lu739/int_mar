<?php

namespace Domain\Order\Payment;

use Illuminate\Database\Eloquent\Collection;
use Support\ValueObjects\Price;

class PaymentData
{
    public function __construct(
        public string $paymentId,
        public string $description,
        public string $returnUrl,
        public Price $amount,
        public Collection $meta,
    )
    {
    }
}

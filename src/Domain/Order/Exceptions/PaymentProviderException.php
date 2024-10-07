<?php

namespace Domain\Order\Exceptions;

class PaymentProviderException extends \Exception
{
    public static function providerRequired(): self
    {
        return new self('Payment provider is required');
    }
}

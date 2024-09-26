<?php

namespace Support\ValueObjects;

use InvalidArgumentException;

class Price
{

    private array $currencies = [
        'RUB' => '₽',
    ];
    public function __construct(
        private readonly float $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 2
    )
    {
        if ($this->value < 0) {
            throw new InvalidArgumentException('Price cannot be negative');
        }

        if (!array_key_exists($this->currency, $this->currencies)) {
            throw new InvalidArgumentException('Currency not found');
        }
    }

    public function raw()
    {
        return $this->value;
    }

    public function currency()
    {
        return $this->currency;
    }
    public function symbol()
    {
        return $this->currencies[$this->currency];
    }

    public function __toString()
    {
        return number_format($this->raw(), $this->precision, ',', ' ')
            . ' ' . $this->symbol();
    }
}

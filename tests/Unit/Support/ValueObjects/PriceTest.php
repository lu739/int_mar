<?php

namespace Tests\Unit\Support\ValueObjects;

use Support\ValueObjects\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    public function test_price_success()
    {
        $price = new Price(1000.2, 'RUB');

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals('1 000,20 ₽', (string) $price);
        $this->assertEquals('₽', $price->symbol());

        $this->expectException(\InvalidArgumentException::class);

        new Price(-1000, 'RUB');
        new Price(10000, 'USD');
    }
}

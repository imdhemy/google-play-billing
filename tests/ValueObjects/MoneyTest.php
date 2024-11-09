<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\Serializer;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Tests\TestCase;

final class MoneyTest extends TestCase
{
    /** @test */
    public function properties(): void
    {
        $data = [
            'currencyCode' => $this->faker->currencyCode(),
            'units' => (string)$this->faker->randomNumber(5),
            'nanos' => $this->faker->randomNumber(5),
        ];

        $money = Serializer::create()->deserialize($data, Money::class);

        $this->assertEquals($data['currencyCode'], $money->currencyCode);
        $this->assertEquals($data['units'], $money->units);
    }
}

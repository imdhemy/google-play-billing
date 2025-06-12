<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\Money;
use Tests\TestCase;

final class MoneyTest extends TestCase
{
    /** @test */
    public function instantiate(): void
    {
        $data = [
            'currencyCode' => $this->faker->currencyCode(),
            'units' => (string)$this->faker->randomNumber(5),
            'nanos' => $this->faker->randomNumber(5),
        ];

        $money = $this->normalizer->normalize($data, Money::class);

        $this->assertEquals($data['currencyCode'], $money->currencyCode);
        $this->assertEquals($data['units'], $money->units);
        $this->assertEquals($data['nanos'], $money->nanos);
    }
}

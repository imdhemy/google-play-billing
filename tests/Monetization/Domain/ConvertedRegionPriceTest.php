<?php

declare(strict_types=1);

namespace Tests\Monetization\Domain;

use Imdhemy\GooglePlay\Monetization\Domain\ConvertedRegionPrice;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Tests\TestCase;

final class ConvertedRegionPriceTest extends TestCase
{
    /** @test */
    public function instantiate(): void
    {
        $data = [
            'regionCode' => $this->faker->countryCode(),
            'price' => [
                'currencyCode' => $this->faker->currencyCode(),
                'units' => (string)$this->faker->randomNumber(5),
                'nanos' => $this->faker->randomNumber(5),
            ],
            'taxAmount' => [
                'currencyCode' => $this->faker->currencyCode(),
                'units' => (string)$this->faker->randomNumber(5),
                'nanos' => $this->faker->randomNumber(5),
            ],
        ];

        $actual = $this->normalizer->normalize($data, ConvertedRegionPrice::class);

        $this->assertInstanceOf(ConvertedRegionPrice::class, $actual);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertInstanceOf(Money::class, $actual->price);
        $this->assertInstanceOf(Money::class, $actual->taxAmount);
    }
}

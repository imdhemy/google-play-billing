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
        $price = new Money(
            $this->faker->currencyCode(),
            (string)$this->faker->randomNumber(5),
            $this->faker->randomNumber(5)
        );
        $taxAmount = new Money(
            $this->faker->currencyCode(),
            (string)$this->faker->randomNumber(5),
            $this->faker->randomNumber(5)
        );
        $data = [
            'regionCode' => $this->faker->countryCode(),
            'price' => [
                'currencyCode' => $price->currencyCode,
                'units' => $price->units,
                'nanos' => $price->nanos,
            ],
            'taxAmount' => [
                'currencyCode' => $taxAmount->currencyCode,
                'units' => $taxAmount->units,
                'nanos' => $taxAmount->nanos,
            ],
        ];

        $actual = $this->normalizer->normalize($data, ConvertedRegionPrice::class);

        $this->assertInstanceOf(ConvertedRegionPrice::class, $actual);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertEquals($price, $actual->price);
        $this->assertEquals($taxAmount, $actual->taxAmount);
    }
}

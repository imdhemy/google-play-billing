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
            'regionCode' => 'DE',
            'price' => [
                'currencyCode' => 'EUR',
                'units' => '4',
                'nanos' => 490000000,
            ],
            'taxAmount' => [
                'currencyCode' => 'EUR',
                'units' => '0',
                'nanos' => 0,
            ],
        ];

        $actual = $this->normalizer->normalize($data, ConvertedRegionPrice::class);

        $this->assertInstanceOf(ConvertedRegionPrice::class, $actual);
        $this->assertEquals('DE', $actual->regionCode);
        $this->assertEquals(new Money('EUR', '4', 490000000), $actual->price);
        $this->assertEquals(new Money('EUR', '0', 0), $actual->taxAmount);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Monetization\Domain;

use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Tests\TestCase;

final class ConvertedPricesTest extends TestCase
{
    /** @test */
    public function instantiate(): void
    {
        $data = [
            'convertedRegionPrices' => [
                'DE' => [
                    'regionCode' => 'DE',
                    'price' => [
                        'currencyCode' => 'EUR',
                        'units' => '10',
                        'nanos' => 990000000,
                    ],
                    'taxAmount' => [
                        'currencyCode' => 'EUR',
                        'units' => '1',
                        'nanos' => 760000000,
                    ],
                ],
                'JP' => [
                    'regionCode' => 'JP',
                    'price' => [
                        'currencyCode' => 'JPY',
                        'units' => '1480',
                        'nanos' => 0,
                    ],
                    'taxAmount' => [
                        'currencyCode' => 'JPY',
                        'units' => '135',
                        'nanos' => 0,
                    ],
                ],
            ],
            'convertedOtherRegionsPrice' => [
                'usdPrice' => [
                    'currencyCode' => 'USD',
                    'units' => '9',
                    'nanos' => 990000000,
                ],
                'eurPrice' => [
                    'currencyCode' => 'EUR',
                    'units' => '9',
                    'nanos' => 490000000,
                ],
            ],
            'regionVersion' => [
                'version' => '2024/02',
            ],
        ];

        $actual = $this->normalizer->normalize($data, ConvertedPrices::class);

        $this->assertInstanceOf(ConvertedPrices::class, $actual);

        $this->assertCount(2, $actual->convertedRegionPrices);

        $this->assertEquals(new Money('EUR', '10', 990000000), $actual->convertedRegionPrices['DE']->price);
        $this->assertEquals(new Money('EUR', '1', 760000000), $actual->convertedRegionPrices['DE']->taxAmount);

        $this->assertEquals(new Money('JPY', '1480', 0), $actual->convertedRegionPrices['JP']->price);
        $this->assertEquals(new Money('JPY', '135', 0), $actual->convertedRegionPrices['JP']->taxAmount);

        $this->assertEquals(new Money('USD', '9', 990000000), $actual->convertedOtherRegionsPrice->usdPrice);
        $this->assertEquals(new Money('EUR', '9', 490000000), $actual->convertedOtherRegionsPrice->eurPrice);

        $this->assertEquals('2024/02', $actual->regionVersion->version);
    }
}

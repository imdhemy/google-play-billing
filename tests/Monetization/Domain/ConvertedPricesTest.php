<?php

declare(strict_types=1);

namespace Tests\Monetization\Domain;

use Imdhemy\GooglePlay\Monetization\Domain\ConvertedOtherRegionsPrice;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedRegionPrice;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Imdhemy\GooglePlay\ValueObjects\RegionsVersion;
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
        $convertedRegionPrices = [
            'DE' => new ConvertedRegionPrice(
                regionCode: 'DE',
                price: new Money(currencyCode: 'EUR', units: '10', nanos: 990000000),
                taxAmount: new Money(currencyCode: 'EUR', units: '1', nanos: 760000000),
            ),
            'JP' => new ConvertedRegionPrice(
                regionCode: 'JP',
                price: new Money(currencyCode: 'JPY', units: '1480', nanos: 0),
                taxAmount: new Money(currencyCode: 'JPY', units: '135', nanos: 0),
            ),
        ];
        $convertedOtherRegionsPrice = new ConvertedOtherRegionsPrice(
            usdPrice: new Money(currencyCode: 'USD', units: '9', nanos: 990000000),
            eurPrice: new Money(currencyCode: 'EUR', units: '9', nanos: 490000000),
        );
        $regionVersion = new RegionsVersion(version: '2024/02');
        $this->assertEquals($convertedRegionPrices, $actual->convertedRegionPrices);
        $this->assertEquals($convertedOtherRegionsPrice, $actual->convertedOtherRegionsPrice);
        $this->assertEquals($regionVersion, $actual->regionVersion);
    }
}

<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Provider\Base;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Psr\Http\Message\ResponseInterface;

final class MonetizationProvider extends Base
{
    public function convertRegionPricesQuery(): ConvertRegionPricesQuery
    {
        return new ConvertRegionPricesQuery(
            packageName: 'com.some.thing',
            price: new Money('USD', '10', 3333333),
        );
    }

    public function convertRegionPricesResponse(): ResponseInterface
    {
        return new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: json_encode($this->convertRegionPricesResponseBody(), JSON_PARTIAL_OUTPUT_ON_ERROR)
        );
    }

    public function convertRegionPricesResponseBody(): array
    {
        return [
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
    }
}

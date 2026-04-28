<?php

declare(strict_types=1);

namespace Tests\AAA;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

final class MonetizationProvider
{
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

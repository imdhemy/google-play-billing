<?php

declare(strict_types=1);

namespace Tests\Monetization\Application;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\ValueObjects\RegionPrice;
use Tests\TestCase;

class ConvertRegionPricesTest extends TestCase
{
    /** @test */
    public function execute(): void
    {
        $data = [
            'packageName' => 'com.some.thing',
            'price' => [
                'currencyCode' => 'USD',
                'units' => '10',
                'nanos' => 3333333,
            ],
        ];
        $body = [
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
        $response = new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: $this->serializer->serialize(data: $body),
        );
        $regionPrice = $this->normalizer->normalize(data: $data, type: RegionPrice::class);
        $history = [];
        $client = $this->mockClient(responses: [$response], history: $history);

        $sut = new ConvertRegionPrices(client: $client, serializer: $this->serializer, normalizer: $this->normalizer);
        $actual = $sut->execute(regionPrice: $regionPrice);
        $expected = $this->normalizer->normalize($body, ConvertedPrices::class);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: sprintf(
                    'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/pricing:convertRegionPrices',
                    $regionPrice->packageName
                ),
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: $this->serializer->serialize(data: [
                    'price' => $regionPrice->price,
                ]),
            ),
        );
        $this->assertEquals($expected, $actual);
    }
}

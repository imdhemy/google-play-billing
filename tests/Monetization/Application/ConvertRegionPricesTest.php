<?php

declare(strict_types=1);

namespace Tests\Monetization\Application;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;
use Imdhemy\GooglePlay\Monetization\Application\MonetizationRequestFactoryInterface;
use Imdhemy\GooglePlay\Monetization\Application\Query\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\Monetization\Infrastructure\MonetizationRequestFactory;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Tests\TestCase;

final class ConvertRegionPricesTest extends TestCase
{
    #[Test]
    public function execute(): void
    {
        $regionPrice = $this->getFakePayload();
        $body = $this->getFakeResponseBody();
        $response = new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: $this->serializer->serialize(data: $body),
        );
        $history = [];
        $client = $this->mockClient(responses: [$response], history: $history);
        $requestFactory = $this->createMonetizationRequestFactory();
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $actual = $sut->execute($regionPrice);

        $expected = $this->normalizer->normalize(data: $body, type: ConvertedPrices::class);
        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: sprintf(
                    'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/pricing:convertRegionPrices',
                    $regionPrice->packageName
                ),
                body: $this->serializer->serialize(data: [
                    'price' => $regionPrice->price,
                ]),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    #[Test]
    public function execute_with_invalid_json_response(): void
    {
        $regionPrice = $this->getFakePayload();
        $body = $this->getFakeResponseBody();
        $response = new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: substr($this->serializer->serialize(data: $body), 0, 10), // invalid json
        );
        $history = [];
        $client = $this->mockClient(responses: [$response], history: $history);
        $requestFactory = $this->createMonetizationRequestFactory();
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);
        $this->expectException(NotEncodableValueException::class);
        $this->expectExceptionMessage('Control character error, possibly incorrectly encoded');
        $actual = $sut->execute($regionPrice);

        $expected = $this->normalizer->normalize(data: $body, type: ConvertedPrices::class);
        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: sprintf(
                    'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/pricing:convertRegionPrices',
                    $regionPrice->packageName
                ),
                body: $this->serializer->serialize(data: [
                    'price' => $regionPrice->price,
                ]),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    private function getFakePayload(): ConvertRegionPricesQuery
    {
        $data = [
            'packageName' => 'com.some.thing',
            'price' => [
                'currencyCode' => 'USD',
                'units' => '10',
                'nanos' => 3333333,
            ],
        ];

        return $this->normalizer->normalize(data: $data, type: ConvertRegionPricesQuery::class);
    }

    private function getFakeResponseBody(): array
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

    private function createMonetizationRequestFactory(): MonetizationRequestFactoryInterface
    {
        return new MonetizationRequestFactory(
            serializer: $this->serializer,
        );
    }
}

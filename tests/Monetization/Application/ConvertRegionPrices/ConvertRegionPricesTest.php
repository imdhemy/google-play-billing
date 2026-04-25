<?php

declare(strict_types=1);

namespace Tests\Monetization\Application\ConvertRegionPrices;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPrices;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesException;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Application\MonetizationRequestFactoryInterface;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\Monetization\Infrastructure\GooglePlayMonetizationRequestFactory;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use RuntimeException;
use Tests\TestCase;

final class ConvertRegionPricesTest extends TestCase
{
    #[Test]
    public function it_returns_converted_prices_and_sends_the_expected_request(): void
    {
        $query = $this->getFakeQuery();
        $body = $this->getFakeResponseBody();
        $response = new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: $this->serializer->serialize(data: $body),
        );
        $history = [];
        $client = $this->mockClient(responses: [$response], history: $history);
        $requestFactory = $this->createConvertRegionPricesRequestFactory();
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $actual = $sut->execute($query);

        $expected = $this->normalizer->normalize(data: $body, type: ConvertedPrices::class);
        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: sprintf(
                    'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/pricing:convertRegionPrices',
                    $query->packageName
                ),
                body: $this->serializer->serialize(data: [
                    'price' => $query->price,
                ]),
            ),
        );
        $this->assertEquals($expected, $actual);
    }

    #[Test]
    public function it_fails_when_the_request_cannot_be_created(): void
    {
        $query = $this->getFakeQuery();
        $client = $this->mockClient(responses: [new Response()]);
        $requestFactory = $this->createFailingConvertRegionPricesRequestFactory();
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $this->expectException(ConvertRegionPricesException::class);
        $this->expectExceptionMessage('Failed to convert region prices.');

        $sut->execute($query);
    }

    #[Test]
    public function it_fails_when_the_request_cannot_be_sent(): void
    {
        $query = $this->getFakeQuery();
        $request = new Request(method: 'POST', uri: 'https://example.com');
        $client = $this->mockClient(responses: [new RequestException('Request failed.', $request)]);
        $requestFactory = $this->createConvertRegionPricesRequestFactory();
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $this->expectException(ConvertRegionPricesException::class);
        $this->expectExceptionMessage('Failed to convert region prices.');

        $sut->execute($query);
    }

    #[Test]
    public function it_fails_when_the_response_cannot_be_normalized(): void
    {
        $query = $this->getFakeQuery();
        $body = $this->getFakeResponseBody();
        $response = new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: substr($this->serializer->serialize(data: $body), 0, 10), // invalid json
        );
        $client = $this->mockClient(responses: [$response]);
        $requestFactory = $this->createConvertRegionPricesRequestFactory();
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $this->expectException(ConvertRegionPricesException::class);
        $this->expectExceptionMessage('Failed to convert region prices.');

        $sut->execute($query);
    }

    private function getFakeQuery(): ConvertRegionPricesQuery
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

    private function createConvertRegionPricesRequestFactory(): MonetizationRequestFactoryInterface
    {
        return new GooglePlayMonetizationRequestFactory(
            serializer: $this->serializer,
        );
    }

    private function createFailingConvertRegionPricesRequestFactory(): MonetizationRequestFactoryInterface
    {
        return new class implements MonetizationRequestFactoryInterface {
            public function createConvertRegionPricesRequest(ConvertRegionPricesQuery $query): RequestInterface
            {
                throw new RuntimeException('Request creation failed.');
            }
        };
    }
}

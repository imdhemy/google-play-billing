<?php

declare(strict_types=1);

namespace Tests\Monetization\Application\ConvertRegionPrices;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPrices;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesException;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Application\MonetizationRequestFactoryInterface;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\Monetization\Infrastructure\GooglePlayMonetizationRequestFactory;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

final class ConvertRegionPricesTest extends TestCase
{
    #[Test]
    public function it_returns_converted_prices_and_sends_the_expected_request(): void
    {
        $query = new ConvertRegionPricesQuery(
            packageName: 'com.some.thing',
            price: new Money('USD', '10', 3333333),
        );
        $responseBody = $this->faker->convertRegionPricesResponseBody();
        $response = $this->faker->convertRegionPricesResponse();
        $history = [];
        $client = $this->mockClient(responses: [$response], history: $history);
        $requestFactory = new GooglePlayMonetizationRequestFactory(
            serializer: $this->serializer,
        );
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $actualConvertedPrices = $sut->execute($query);

        $expectedRequest = new Request(
            method: 'POST',
            uri: sprintf(
                'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/pricing:convertRegionPrices',
                $query->packageName
            ),
            body: $this->serializer->serialize(data: [
                'price' => $query->price,
            ]),
        );
        $expectedConvertedPrices = $this->normalizer->normalize(data: $responseBody, type: ConvertedPrices::class);

        $this->assertClientSentRequest(history: $history, request: $expectedRequest);
        $this->assertEquals($expectedConvertedPrices, $actualConvertedPrices);
    }

    #[Test]
    #[AllowMockObjectsWithoutExpectations]
    public function it_wraps_failures_in_a_convert_region_prices_exception(): void
    {
        $query = new ConvertRegionPricesQuery(
            packageName: 'com.some.thing',
            price: new Money('USD', '10', 3333333),
        );
        $client = $this->mockClient(responses: [$this->faker->convertRegionPricesResponse()]);
        $requestFactory = $this->createMock(MonetizationRequestFactoryInterface::class);
        $requestFactory
            ->method('createConvertRegionPricesRequest')
            ->willThrowException(new RuntimeException('Request creation failed.'));
        $sut = new ConvertRegionPrices(client: $client, requestFactory: $requestFactory, normalizer: $this->normalizer);

        $this->expectException(ConvertRegionPricesException::class);
        $this->expectExceptionMessage('Failed to convert region prices.');

        $sut->execute($query);
    }
}

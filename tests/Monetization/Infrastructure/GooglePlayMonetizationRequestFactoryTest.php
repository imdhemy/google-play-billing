<?php

declare(strict_types=1);

namespace Tests\Monetization\Infrastructure;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Infrastructure\GooglePlayMonetizationRequestFactory;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class GooglePlayMonetizationRequestFactoryTest extends TestCase
{
    #[Test]
    public function it_creates_the_convert_region_prices_request(): void
    {
        $query = new ConvertRegionPricesQuery('com.example.app', new Money('USD', '1', 1000));
        $sut = new GooglePlayMonetizationRequestFactory($this->serializer);

        $actual = $sut->createConvertRegionPricesRequest($query);

        $this->assertRequestEquals(
            new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/pricing:convertRegionPrices',
                body: $this->serializer->serialize(data: [
                    'price' => ['currencyCode' => 'USD', 'units' => '1', 'nanos' => 1000],
                ]),
            ),
            $actual
        );
    }
}

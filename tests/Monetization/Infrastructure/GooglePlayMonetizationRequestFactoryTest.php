<?php

declare(strict_types=1);

namespace Tests\Monetization\Infrastructure;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Monetization\Infrastructure\GooglePlayMonetizationRequestFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class GooglePlayMonetizationRequestFactoryTest extends TestCase
{
    #[Test]
    public function it_creates_the_convert_region_prices_request(): void
    {
        $query = $this->faker->convertRegionPricesQuery();
        $sut = new GooglePlayMonetizationRequestFactory($this->serializer);

        $actual = $sut->createConvertRegionPricesRequest($query);

        $this->assertRequestEquals(
            new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.some.thing/pricing:convertRegionPrices',
                body: '{"price":{"currencyCode":"USD","units":"10","nanos":3333333}}',
            ),
            $actual
        );
    }
}

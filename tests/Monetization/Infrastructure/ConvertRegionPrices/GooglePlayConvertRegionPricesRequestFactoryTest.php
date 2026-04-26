<?php

declare(strict_types=1);

namespace Tests\Monetization\Infrastructure\ConvertRegionPrices;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Infrastructure\ConvertRegionPrices\GooglePlayConvertRegionPricesRequestFactory;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class GooglePlayConvertRegionPricesRequestFactoryTest extends TestCase
{
    #[Test]
    public function it_creates_the_convert_region_prices_request(): void
    {
        $productTaxCategoryCode = 'PTC023DIG';
        $query = new ConvertRegionPricesQuery(
            packageName: 'com.some.thing',
            price: new Money('USD', '10', 3333333),
            productTaxCategoryCode: $productTaxCategoryCode,
        );
        $sut = new GooglePlayConvertRegionPricesRequestFactory($this->serializer);

        $actual = $sut->create($query);

        $this->assertRequestEquals(
            new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.some.thing/pricing:convertRegionPrices',
                body: sprintf(
                    '{"price":{"currencyCode":"USD","units":"10","nanos":3333333},"productTaxCategoryCode":"%s"}',
                    $productTaxCategoryCode,
                ),
            ),
            $actual
        );
    }
}

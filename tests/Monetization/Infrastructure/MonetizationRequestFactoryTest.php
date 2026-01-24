<?php

declare(strict_types=1);

namespace Tests\Monetization\Infrastructure;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Monetization\Application\Query\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Infrastructure\MonetizationRequestFactory;
use Imdhemy\GooglePlay\ValueObjects\Money;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Tests\TestCase;

final class MonetizationRequestFactoryTest extends TestCase
{
    #[Test]
    public function it_should_fail_on_invalid_types(): void
    {
        $sut = new MonetizationRequestFactory($this->serializer);

        $this->expectException(InvalidArgumentException::class);

        $sut->create(new stdClass());
    }

    #[Test]
    public function create_convert_region_prices_request(): void
    {
        $query = new ConvertRegionPricesQuery('com.example.app', new Money('USD', '1', 1000));
        $sut = new MonetizationRequestFactory($this->serializer);

        $actual = $sut->create($query);

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

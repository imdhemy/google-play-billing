<?php

declare(strict_types=1);

namespace Tests\Monetization\Application\ConvertRegionPrices;

use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ConvertRegionPricesQueryTest extends TestCase
{
    #[Test]
    public function it_can_be_created_for_a_package_price(): void
    {
        $price = new Money('USD', '10', 3333333);

        $query = new ConvertRegionPricesQuery(
            packageName: 'com.example.app',
            price: $price,
        );

        $this->assertSame('com.example.app', $query->packageName);
        $this->assertSame($price, $query->price);
    }

    #[Test]
    public function it_serializes_only_the_request_body(): void
    {
        $price = new Money('USD', '10', 3333333);
        $query = new ConvertRegionPricesQuery(
            packageName: 'com.example.app',
            price: $price,
        );

        $actual = $query->jsonSerialize();

        $this->assertSame(['price' => $price], $actual);
    }
}

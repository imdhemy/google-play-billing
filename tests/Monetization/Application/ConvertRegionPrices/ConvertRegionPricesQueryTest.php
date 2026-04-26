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
        $productTaxCategoryCode = 'PTC023DIG';

        $query = new ConvertRegionPricesQuery(
            packageName: 'com.example.app',
            price: $price,
            productTaxCategoryCode: $productTaxCategoryCode,
        );

        $this->assertSame('com.example.app', $query->packageName);
        $this->assertSame($price, $query->price);
        $this->assertSame($productTaxCategoryCode, $query->productTaxCategoryCode);
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

    #[Test]
    public function it_serializes_the_product_tax_category_code_when_present(): void
    {
        $price = new Money('USD', '10', 3333333);
        $productTaxCategoryCode = 'PTC023DIG';
        $query = new ConvertRegionPricesQuery(
            packageName: 'com.example.app',
            price: $price,
            productTaxCategoryCode: $productTaxCategoryCode,
        );

        $actual = $query->jsonSerialize();

        $this->assertSame([
            'price' => $price,
            'productTaxCategoryCode' => $productTaxCategoryCode,
        ], $actual);
    }
}

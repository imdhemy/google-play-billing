<?php

declare(strict_types=1);

namespace Tests\Monetization\Application\ConvertRegionPrices;

use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ConvertRegionPricesQueryTest extends TestCase
{
    #[Test]
    public function it_can_be_normalized_from_array_data(): void
    {
        $data = [
            'packageName' => $this->faker->domainName(),
            'price' => [
                'currencyCode' => $this->faker->currencyCode(),
                'units' => (string)$this->faker->randomNumber(5),
                'nanos' => $this->faker->randomNumber(5),
            ],
        ];

        $query = $this->normalizer->normalize(
            data: $data,
            type: ConvertRegionPricesQuery::class,
        );

        $this->assertEquals($data['packageName'], $query->packageName);
        $this->assertEquals($data['price']['currencyCode'], $query->price->currencyCode);
        $this->assertEquals($data['price']['units'], $query->price->units);
        $this->assertEquals($data['price']['nanos'], $query->price->nanos);
    }
}

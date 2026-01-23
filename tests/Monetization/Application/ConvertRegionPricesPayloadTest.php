<?php

declare(strict_types=1);

namespace Tests\Monetization\Application;

use Imdhemy\GooglePlay\Monetization\Application\Query\ConvertRegionPricesQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ConvertRegionPricesPayloadTest extends TestCase
{
    #[Test]
    public function instantiate(): void
    {
        $data = [
            'packageName' => $this->faker->domainName(),
            'price' => [
                'currencyCode' => $this->faker->currencyCode(),
                'units' => (string)$this->faker->randomNumber(5),
                'nanos' => $this->faker->randomNumber(5),
            ],
        ];

        $payload = $this->normalizer->normalize(
            data: $data,
            type: ConvertRegionPricesQuery::class,
        );

        $this->assertEquals($data['packageName'], $payload->packageName);
        $this->assertEquals($data['price']['currencyCode'], $payload->price->currencyCode);
        $this->assertEquals($data['price']['units'], $payload->price->units);
        $this->assertEquals($data['price']['nanos'], $payload->price->nanos);
    }
}

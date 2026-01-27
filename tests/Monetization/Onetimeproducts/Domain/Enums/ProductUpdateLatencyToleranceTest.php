<?php

declare(strict_types=1);

namespace Tests\Monetization\Onetimeproducts\Domain\Enums;

use Imdhemy\GooglePlay\Monetization\Onetimeproducts\Domain\Enums\ProductUpdateLatencyTolerance;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProductUpdateLatencyToleranceTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $data = $this->faker->randomElement([
            'PRODUCT_UPDATE_LATENCY_TOLERANCE_UNSPECIFIED',
            'PRODUCT_UPDATE_LATENCY_TOLERANCE_LATENCY_SENSITIVE',
            'PRODUCT_UPDATE_LATENCY_TOLERANCE_LATENCY_TOLERANT',
        ]);

        $actual = $this->normalizer->normalize($data, ProductUpdateLatencyTolerance::class);

        $this->assertInstanceOf(ProductUpdateLatencyTolerance::class, $actual);
        $this->assertSame($data, $actual->value);
    }
}

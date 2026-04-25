<?php

declare(strict_types=1);

namespace Tests\Monetization\Application\ConvertRegionPrices;

use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesException;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

final class ConvertRegionPricesExceptionTest extends TestCase
{
    #[Test]
    public function it_describes_conversion_failures(): void
    {
        $previous = new RuntimeException('Previous failure.');

        $actual = ConvertRegionPricesException::failed($previous);

        $this->assertSame('Failed to convert region prices.', $actual->getMessage());
        $this->assertSame($previous, $actual->getPrevious());
    }
}

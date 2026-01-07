<?php

namespace Imdhemy\GooglePlay\Monetization\Application;

use Imdhemy\GooglePlay\ValueObjects\Money;

final readonly class ConvertRegionPricesPayload
{
    public function __construct(
        public string $packageName,
        public Money $price,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application\Query;

use Imdhemy\GooglePlay\ValueObjects\Money;

final readonly class ConvertRegionPricesQuery
{
    public function __construct(
        public string $packageName,
        public Money $price,
    ) {
    }
}

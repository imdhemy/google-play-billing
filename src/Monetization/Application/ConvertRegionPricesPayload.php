<?php

namespace Imdhemy\GooglePlay\Monetization\Application;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Represent the price of a package in a specific region.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/monetization/convertRegionPrices
 */
final readonly class ConvertRegionPricesPayload
{
    public function __construct(
        public string $packageName,
        public Money $price,
    ) {
    }
}

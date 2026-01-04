<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Represent the price of a package in a specific region.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/monetization/convertRegionPrices
 */
final readonly class RegionPrice
{
    public function __construct(
        public string $packageName,
        public Money $price,
    ) {
    }
}

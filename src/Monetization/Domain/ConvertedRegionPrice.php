<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Domain;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Represents the converted region price.
 *
 * @link https://developers.google.com/android-publisher/api-ref/rest/v3/monetization/convertRegionPrices#convertedregionprice
 */
final readonly class ConvertedRegionPrice
{
    public function __construct(
        public string $regionCode,
        public Money $price,
        public Money $taxAmount,
    ) {
    }
}
